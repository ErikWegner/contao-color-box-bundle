<?php

/*
 * This file is part of Color Box.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\ContaoColorBoxBundle\Models;

use Contao\Model;

class ColorBoxModel extends Model
{
	/**
	 * Table name
	 * @var string
	 */
    protected static $strTable = 'tl_colorbox_colors';

	/**
	 * Count published items
	 *
	 * @return integer The number of items
	 */
	public static function countPublished()
	{
        return static::countBy();
    }

	/**
	 * Find published items
	 *
	 * @param integer $intLimit    An optional limit
	 * @param integer $intOffset   An optional offset
	 *
	 * @return Model\Collection|ColorBoxModel[]|ColorBoxModel|null A collection of models or null if there are none
	 */
	public static function findPublished($intLimit=0, $intOffset=0)
	{
        $arrOptions['limit']  = $intLimit;
		$arrOptions['offset'] = $intOffset;

		return static::findBy(null, null, $arrOptions);
	}
}
