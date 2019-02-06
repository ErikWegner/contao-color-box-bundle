<?php

/**
 * Add back end module
 */
array_insert(
    $GLOBALS['BE_MOD']['content'],
    2,
    array(
        'colorBox' => array(
            'tables' => array('tl_colorbox_colors'),
        )
    )
);

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['miscellaneous']['colorBox']
    = 'ErikWegner\ContaoColorBoxBundle\Module\ColorBoxModule';

// Front end modules
array_insert($GLOBALS['FE_MOD'], 2, array
(
	'colorBox' => array
	(
		'colorBoxlist'    => 'ErikWegner\ContaoColorBoxBundle\Module\ModuleColorBoxList',
		/*'newsreader'  => 'ModuleNewsReader',
		'newsarchive' => 'ModuleNewsArchive',
		'newsmenu'    => 'ModuleNewsMenu'*/
	)
));

/**
 * Models registrieren
 */
$GLOBALS['TL_MODELS']['tl_colorbox_colors'] = 'ErikWegner\ContaoColorBoxBundle\Models\ColorBoxModel';
