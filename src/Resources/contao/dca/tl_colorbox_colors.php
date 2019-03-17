<?php

/*
 * This file is part of Color Box.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

/**
 * Table tl_colorbox_colors
 */
$GLOBALS['TL_DCA']['tl_colorbox_colors'] = array(
    // Config
    'config' => array(
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => array(
            'keys' => array(
                'id' => 'primary'
            )
        ),
    ),
    // List
    'list' => array(
        'sorting' => array(
            'mode' => 1,
            'fields' => array('title'),
            'flag' => 1,
            'panelLayout' => 'search,limit'
        ),
        'label' => array(
            'fields' => array('title'),
            'format' => '%s'
        ),
        'global_operations' => array(
            'all' => array(
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array(
            'edit' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_colorbox_colors']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.gif'
            ),
            'copy' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_colorbox_colors']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ),
            'delete' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_colorbox_colors']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_colorbox_colors']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array(
                'label' => &$GLOBALS['TL_LANG']['tl_colorbox_colors']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif'
            )
        )
    ),
    // Palettes
    'palettes' => array(
        'default' => '{title_legend},title,color'
    ),
    // Fields
    'fields' => array(
        'id' => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_colorbox_colors']['title'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'sql' => "varchar(255) NOT NULL default ''",
            'eval' => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50')
        ),
        'color' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_colorbox_colors']['color'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'sql' => "varchar(6) NOT NULL default '000000'",
            'eval' => array('mandatory' => true, 'maxlength' => 6, 'tl_class' => 'w50')
        ),
    )
);
