<?php

/*
 * This file is part of Color Box.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\ContaoColorBoxBundle\Module;

use System;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Patchwork\Utf8;
use ErikWegner\ContaoColorBoxBundle\Models\ColorBoxModel;

/**
 * Front end module "colorBox list".

 * @property string $colorbox_template
 */
class ModuleColorBoxList extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_colorBoxlist';

	/**
	 * Display a wildcard in the back end
	 *
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['colorBox'][1]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$limit = null;
		$offset = (int) $this->skipFirst;

		// Maximum number of items
		if ($this->numberOfItems > 0)
		{
			$limit = $this->numberOfItems;
		}

		$this->Template->colors = array();
		$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyList'];

		// Get the total number of items
		$intTotal = $this->countItems();

		if ($intTotal < 1)
		{
			return;
		}

		$total = $intTotal - $offset;

		// Split the results
		if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
		{
			// Adjust the overall limit
			if (isset($limit))
			{
				$total = min($limit, $total);
			}

			// Get the current page
			$id = 'page_n' . $this->id;
			$page = \Input::get($id) ?? 1;

			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
			{
				throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
			}

			// Set limit and offset
			$limit = $this->perPage;
			$offset += (max($page, 1) - 1) * $this->perPage;
			$skip = (int) $this->skipFirst;

			// Overall limit
			if ($offset + $limit > $total + $skip)
			{
				$limit = $total + $skip - $offset;
			}

			// Add the pagination menu
			$objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}

		$objColors = $this->fetchItems(($limit ?: 0), $offset);

		// Add the colors
		if ($objColors !== null)
		{
            $this->Template->colors = $this->parseColors($objColors);
            //$this->Template->colors = [print_r($objColors, TRUE)];
        }
	}

	/**
	 * Count the total matching items
	 *
	 * @return integer
	 */
	protected function countItems()
	{
		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['colorBoxListCountItems']) && \is_array($GLOBALS['TL_HOOKS']['colorBoxListCountItems']))
		{
			foreach ($GLOBALS['TL_HOOKS']['colorBoxListCountItems'] as $callback)
			{
				if (($intResult = \System::importStatic($callback[0])->{$callback[1]}($this)) === false)
				{
					continue;
				}

				if (\is_int($intResult))
				{
					return $intResult;
				}
			}
		}

		return ColorBoxModel::countPublished();
	}

	/**
	 * Fetch the matching items
	 *
	 * @param integer $limit
	 * @param integer $offset
	 *
	 * @return Model\Collection|ColorBoxModel|null
	 */
	protected function fetchItems($limit, $offset)
	{
		// HOOK: add custom logic
		if (isset($GLOBALS['TL_HOOKS']['colorBoxListFetchItems']) && \is_array($GLOBALS['TL_HOOKS']['colorBoxListFetchItems']))
		{
			foreach ($GLOBALS['TL_HOOKS']['colorBoxListFetchItems'] as $callback)
			{
				if (($objCollection = \System::importStatic($callback[0])->{$callback[1]}($limit, $offset, $this)) === false)
				{
					continue;
				}

				if ($objCollection === null || $objCollection instanceof Model\Collection)
				{
					return $objCollection;
				}
			}
		}

		return ColorBoxModel::findPublished($limit, $offset);
    }

    /**
	 * Parse an item and return it as string
	 *
	 * @param ColorBoxModel $objColors
	 * @param string    $strClass
	 * @param integer   $intCount
	 *
	 * @return string
	 */
	protected function parseColors($objColors, $strClass='', $intCount=0)
	{
        $colors = [];
		$objTemplate = new \FrontendTemplate('mod_colorBoxlistitem');
        foreach ($objColors->getModels() as $model) {
            $objTemplate->setData($model->row());
            $colors[] = $objTemplate->parse();
        }

		// Tag the response
		if (System::getContainer()->has('fos_http_cache.http.symfony_response_tagger'))
		{
			/** @var ResponseTagger $responseTagger */
			$responseTagger = System::getContainer()->get('fos_http_cache.http.symfony_response_tagger');
			$responseTagger->addTags(array('contao.db.tl_colorbox_colors.' . $objColors->id));
		}

		return $colors;
	}
}

class_alias(ModuleColorBoxList::class, 'ModuleColorBoxList');
