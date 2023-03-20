<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\BackendUser;
use Contao\System;

System::loadLanguageFile('tl_content');
System::loadLanguageFile('tl_members');
System::loadLanguageFile('tl_ff_ranks');
System::loadLanguageFile('tl_ff_functions');

    // add class clr to existing field firstname
    // $GLOBALS['TL_DCA']['tl_member']['fields']['firstname']['eval']['tl_class'] .= ' clr';

    // Fields
    // Präfix
    $GLOBALS['TL_DCA']['tl_member']['fields']['prefix'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['prefix'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    // Suffix
    $GLOBALS['TL_DCA']['tl_member']['fields']['suffix'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['suffix'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 255, 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    // Dienstrang - Quelldaten aus tl_ranks
    $GLOBALS['TL_DCA']['tl_member']['fields']['rank'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['rank'],
        'inputType'               => 'select',
        'options_callback' => function () {
            $options = array();
            $data = Contao\Database::getInstance()->execute("SELECT id,ff_rank_short,ff_rank_long FROM tl_ff_ranks ORDER BY ff_rank_long ASC");
            while ($data->next())
            {                
              $options[$data->id] = $data->ff_rank_long;
            }
            return $options;
        },
        'eval'                    => ['maxlength' => 255, 'includeBlankOption' => 'true', 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    // Ehrendienstgrad
    $GLOBALS['TL_DCA']['tl_member']['fields']['honory'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['honory'],
        'inputType'               => 'checkbox',
        'eval'                    => ['tl_class' => 'w50 m12'],
        'sql'                     => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => '']
    ];
    // Mitglied seit
    $GLOBALS['TL_DCA']['tl_member']['fields']['member_since'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['member_since'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 4, 'rgxp' => 'natural','tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 4, 'default' => '']
    ];
    // Foto des Mitglieds
    $GLOBALS['TL_DCA']['tl_member']['fields']['singleSRC'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
        'inputType'               => 'fileTree',
        'eval'                    => ['fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>'%contao.image.valid_extensions%', 'tl_class'=>'clr'],
        'sql'                     => ['type' => 'binary', 'length' => 16, 'default' => 'NULL']
    ];
    // Bildgröße
    $GLOBALS['TL_DCA']['tl_member']['fields']['size'] = [
		'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['MSC']['imgSize'],
        'inputType'               => 'imageSize',
        'reference'               => &$GLOBALS['TL_LANG']['MSC'],
        'eval'                    => ['rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'],
        'sql'                     => ['type' => 'string', 'length' => 64, 'default' => ''],
        'options_callback' => static function ()
        {
            return System::getContainer()->get('contao.image.sizes')->getOptionsForUser(BackendUser::getInstance());
        },	
    ];
    // Alternativtext zum Bild
    $GLOBALS['TL_DCA']['tl_member']['fields']['alt'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
        'inputType'               => 'text',
        'eval'                    => ['length'=>255, 'tl_class'=>'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'fixed' => true, 'default' => '']
    ];
    // Titel zum Bild
    $GLOBALS['TL_DCA']['tl_member']['fields']['imageTitle'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imageTitle'],
        'inputType'               => 'text',
        'eval'                    => ['length'=>255, 'tl_class'=>'w50'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'fixed' => true, 'default' => '']
    ];

 
// Aktuelle örtliche Funktion(en)

    $GLOBALS['TL_DCA']['tl_member']['fields']['functions_local'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['function'],
        'inputType'               => 'select',
        'options_callback'        => function () {
            $options = [];
            $data = Contao\Database::getInstance()->execute("SELECT id,ff_function_short,ff_function_long,ff_function_overlocal FROM tl_ff_functions WHERE ff_function_overlocal = 0 ORDER BY ff_function_long ASC");
            while ($data->next())
            {                
                $options[$data->id] = $data->ff_function_long;
            }
            return $options;
        },
        'eval'                    => ['tl_class' => 'w50'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];          
    $GLOBALS['TL_DCA']['tl_member']['fields']['functions_local_start'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['functions_local_start'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 10, 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 10, 'default' => '']
    ];
    $GLOBALS['TL_DCA']['tl_member']['fields']['functions_local_end'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['functions_local_end'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 10, 'tl_class' => 'w50'],
        'sql'                     => ['type' => 'string', 'length' => 10, 'default' => '']
    ];

    // Aktuelle überörtliche Funktion(en)
    $GLOBALS['TL_DCA']['tl_member']['fields']['functions_overlocal'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['function'],
        'inputType'               => 'select',
        'options_callback' => function () {
            $options = array();
            $data = Contao\Database::getInstance()->execute("SELECT id,ff_function_short,ff_function_long,ff_function_overlocal FROM tl_ff_functions WHERE ff_function_overlocal = 1 ORDER BY ff_function_long ASC");
            while ($data->next())
            {                
              $options[$data->id] = $data->ff_function_long;
            }
            return $options;
        },
        'eval'                    => ['maxlength' => 255, 'includeBlankOption' => 'true', 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    // Überörtliche Funktion Beginn
    $GLOBALS['TL_DCA']['tl_member']['fields']['functions_overlocal_start'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['functions_overlocal_start'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 10, 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 10, 'default' => '']
    ];
    // Überörtliche Funktion Ende
    $GLOBALS['TL_DCA']['tl_member']['fields']['functions_overlocal_end'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['functions_overlocal_end'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 10, 'tl_class' => 'w50'],
        'sql'                     => ['type' => 'string', 'length' => 9, 'default' => '']
    ];

    PaletteManipulator::create()
        ->addField('prefix', 'firstname', PaletteManipulator::POSITION_BEFORE)
        ->addField('suffix', 'lastname', PaletteManipulator::POSITION_AFTER)
        ->addField('singleSRC', 'suffix', PaletteManipulator::POSITION_AFTER)
        ->addField('size', 'singleSRC', PaletteManipulator::POSITION_AFTER)
        ->addField('alt', 'size', PaletteManipulator::POSITION_AFTER)
        ->addField('imageTitle', 'alt', PaletteManipulator::POSITION_AFTER)
        ->addField('rank', 'imageTitle', PaletteManipulator::POSITION_AFTER)
        ->addField('honory', 'rank', PaletteManipulator::POSITION_AFTER)
        ->addField('member_since', 'honory', PaletteManipulator::POSITION_AFTER)
        // Add Group functions_local AFTER personal_legend
        ->addLegend('functions_local_legend', 'personal_legend',PaletteManipulator::POSITION_AFTER)
        ->addField('functions_local', 'functions_local_legend', PaletteManipulator::POSITION_APPEND)
        ->addField('functions_local_start', 'functions_local', PaletteManipulator::POSITION_AFTER)
        ->addField('functions_local_end', 'functions_local_start', PaletteManipulator::POSITION_AFTER)
        // Add Group functions_overlocal BEFORE adress
        ->addLegend('functions_overlocal_legend', 'functions_local_legend', PaletteManipulator::POSITION_AFTER)
        ->addField('functions_overlocal', 'functions_overlocal_legend', PaletteManipulator::POSITION_APPEND)
        ->addField('functions_overlocal_start', 'functions_overlocal', PaletteManipulator::POSITION_AFTER)
        ->addfield('functions_overlocal_end', 'functions_overlocal_start', PaletteManipulator::POSITION_AFTER)
        // remove unnessacery fields
        ->removeField('gender', 'personal_legend')
        ->removeField('dateOfBirth', 'personal_legend')
        ->applyToPalette('default', 'tl_member')
;
