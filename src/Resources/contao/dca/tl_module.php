<?php

// Add palette to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['colorBox'] = '{title_legend},name,headline,type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['colorBoxlist'] = '{title_legend},name,headline,type;{config_legend},numberOfItems,perPage;{template_legend:hide},colorbox_template,customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
