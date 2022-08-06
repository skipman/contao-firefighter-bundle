<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\BackendUser;
use Contao\System;
use Contao\Model;

System::loadLanguageFile('tl_content');
System::loadLanguageFile('tl_ff_ranks');

    // add class clr to existing fields firstname and dateOfBirth
    $GLOBALS['TL_DCA']['tl_member']['fields']['firstname']['eval']['tl_class'] .= ' clr';
    $GLOBALS['TL_DCA']['tl_member']['fields']['dateOfBirth']['eval']['tl_class'] .= ' clr';

    // Fields
    $GLOBALS['TL_DCA']['tl_member']['fields']['prefix'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['prefix'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 255, 'tl_class' => 'w50'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    $GLOBALS['TL_DCA']['tl_member']['fields']['suffix'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['suffix'],
        'inputType'               => 'text',
        'eval'                    => ['maxlength' => 255, 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    $GLOBALS['TL_DCA']['tl_member']['fields']['rank'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['rank'],
        'inputType'               => 'select',
        'options'                 => array('Abschnittsbrandinspektor', 'Abschnittssachbearbeiter', 'Bezirksfeuerwehrarzt'),
        'eval'                    => ['maxlength' => 255, 'tl_class' => 'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'default' => '']
    ];
    $GLOBALS['TL_DCA']['tl_member']['fields']['honory'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_member']['honory'],
        'inputType'               => 'checkbox',
        'eval'                    => ['tl_class' => 'w50 m12'],
        'sql'                     => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => '']
    ];
    $GLOBALS['TL_DCA']['tl_member']['fields']['singleSRC'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
        'inputType'               => 'fileTree',
        'eval'                    => ['fieldType'=>'radio', 'filesOnly'=>true, 'extensions'=>'%contao.image.valid_extensions%', 'tl_class'=>'clr'],
        'sql'                     => ['type' => 'binary', 'length' => 16, 'fixed' => true, 'default' => '']
    ];
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
    $GLOBALS['TL_DCA']['tl_member']['fields']['alt'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['alt'],
        'inputType'               => 'text',
        'eval'                    => ['length'=>255, 'tl_class'=>'w50 clr'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'fixed' => true, 'default' => '']
    ];
    $GLOBALS['TL_DCA']['tl_member']['fields']['imageTitle'] = [
        'exclude'                 => true,
        'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imageTitle'],
        'inputType'               => 'text',
        'eval'                    => ['length'=>255, 'tl_class'=>'w50'],
        'sql'                     => ['type' => 'string', 'length' => 255, 'fixed' => true, 'default' => '']
    ];



PaletteManipulator::create()
    ->addField('prefix', 'firstname', PaletteManipulator::POSITION_BEFORE)
    ->addField('suffix', 'lastname', PaletteManipulator::POSITION_AFTER)
    ->addField('rank', 'suffix', PaletteManipulator::POSITION_AFTER)
    ->addField('honory', 'rank', PaletteManipulator::POSITION_AFTER)
    ->addField('singleSRC', 'honory', PaletteManipulator::POSITION_AFTER)
    ->addField('size', 'singleSRC', PaletteManipulator::POSITION_AFTER)
    ->addField('alt', 'size', PaletteManipulator::POSITION_AFTER)
    ->addField('imageTitle', 'alt', PaletteManipulator::POSITION_AFTER)
    ->removeField('gender', 'personal_legend')
    ->removeField('dateOfBirth', 'personal_legend')
    ->applyToPalette('default', 'tl_member')
;
