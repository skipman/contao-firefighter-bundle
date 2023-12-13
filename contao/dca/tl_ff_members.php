<?php

declare(strict_types=1);

/*
 * This file is part of Contao Firefighter Bundle.
 *
 * (c) Ronald Boda 2023 <info@coboda.at>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/skipman/contao-firefighter-bundle
 */

use Contao\Backend;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\System;
use Contao\BackendUser;
use Contao\Config;

System::loadLanguageFile('tl_content');

/**
 * Table tl_ff_members
 */
$GLOBALS['TL_DCA']['tl_ff_members'] = [
    'config'      => [
        'dataContainer'    => DC_Table::class,
        'enableVersioning' => true,
        'sql'              => [
            'keys' => [
                'id' => 'primary'
            ]
        ],
    ],
    'list'        => [
        'sorting'           => [
            'mode'        => DataContainer::MODE_SORTABLE,
            'fields'      => ['ff_member_lastname'],
            'flag'        => DataContainer::SORT_INITIAL_LETTER_ASC,
            'panelLayout' => 'filter;sort,search,limit'
        ],
        'label'             => [
            'fields' => ['ff_member_lastname', 'ff_member_firstname'],
            'format' => '%s %s',
        ],
        'global_operations' => [
            'all' => [
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations'        => [
            'edit'   => [
                'href'  => 'act=edit',
                'icon'  => 'edit.svg'
            ],
            'copy'   => [
                'href'  => 'act=copy',
                'icon'  => 'copy.svg'
            ],
            'delete' => [
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ],
            'show'   => [
                'href'       => 'act=show',
                'icon'       => 'show.svg',
                'attributes' => 'style="margin-right:3px"'
            ],
        ]
    ],
    'palettes'    => [
        '__selector__' => ['addImage', 'overwriteMeta'],
        'default'      => '{basic_legend},ff_member_title,ff_member_firstname,ff_member_lastname,ff_member_suffix,ff_member_rank,ff_member_rank_honory,ff_member_function;{image_legend:hide},addImage;{contact_legend:hide},ff_member_homebase,ff_member_homebase_url,ff_member_email,ff_member_phone'
    ],
    
        // Subpalettes
    'subpalettes' => [
        'addImage'        => 'singleSRC,size,floating,imagemargin,fullsize,overwriteMeta',
        'overwriteMeta'   => 'alt,imageTitle,imageUrl,caption',
    ],
    'fields'      => [
        'id'             => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp'         => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'ff_member_title'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => ['mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_firstname'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_lastname'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'flag'      => DataContainer::SORT_INITIAL_LETTER_ASC,
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_suffix'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => ['mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_rank'    => [
            'inputType' => 'select',
            'exclude'   => true,
            'reference' => &$GLOBALS['TL_LANG']['tl_ff_members'],
            'options_callback'      => ['tl_functions', 'getFfRankShortOptions'],
            'eval'      => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'ff_member_rank_honory'  => [
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 m12'],
            'sql'       => "char(1) NOT NULL default ''"
        ],
        'ff_member_function'    => [
            'inputType' => 'select',
            'exclude'   => true,
            'reference' => &$GLOBALS['TL_LANG']['tl_ff_members'],
            'options_callback'      => ['tl_functions', 'getFfFunctionShortOptions'],
            'eval'      => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        
        /*
        'multitextField' => [
            'inputType' => 'text',
            'exclude'   => true,
            'search'    => true,
            'filter'    => true,
            'sorting'   => true,
            'eval'      => ['multiple' => true, 'size' => 4, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        */
        'addImage'      => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['addImage'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['submitOnChange' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'overwriteMeta' => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['overwriteMeta'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['submitOnChange' => true, 'tl_class' => 'w50 clr'],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'singleSRC'     => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['singleSRC'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => ['fieldType' => 'radio', 'filesOnly' => true, 'extensions' => Config::get('validImageTypes'), 'mandatory' => true],
            'sql'       => 'binary(16) NULL',
        ],
        'alt'           => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['alt'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'imageTitle'    => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['imageTitle'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'size'              => [
            'label'            => &$GLOBALS['TL_LANG']['MSC']['imgSize'],
            'exclude'          => true,
            'inputType'        => 'imageSize',
            'reference'        => &$GLOBALS['TL_LANG']['MSC'],
            'eval'             => ['rgxp' => 'natural', 'includeBlankOption' => true, 'nospace' => true, 'helpwizard' => true, 'tl_class' => 'w50'],
            'options_callback' => function () {
                return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
            },
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'imagemargin'   => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['imagemargin'],
            'exclude'   => true,
            'inputType' => 'trbl',
            'options'   => $GLOBALS['TL_CSS_UNITS'],
            'eval'      => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(128) NOT NULL default ''",
        ],
        'imageUrl'      => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['imageUrl'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['rgxp' => 'url', 'decodeEntities' => true, 'maxlength' => 255, 'dcaPicker' => true, 'tl_class' => 'w50 wizard'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'fullsize'      => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['fullsize'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50 m12'],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'caption'       => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['caption'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['maxlength' => 255, 'allowHtml' => true, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'floating'      => [
            'label'     => &$GLOBALS['TL_LANG']['tl_content']['floating'],
            'default'   => 'above',
            'exclude'   => true,
            'inputType' => 'radioTable',
            'options'   => ['above', 'left', 'right', 'below'],
            'eval'      => ['cols' => 4, 'tl_class' => 'w50'],
            'reference' => &$GLOBALS['TL_LANG']['MSC'],
            'sql'       => "varchar(12) NOT NULL default ''",
        ],
        'ff_member_homebase'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => ['mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_homebase_url'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => ['rgpx' => 'url', 'decodeEntities' => true, 'mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_email'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => ['rgpx' => 'email', 'mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'ff_member_phone'          => [
            'inputType' => 'text',
            'exclude'   => true,
            'eval'      => ['rgpx' => 'phone', 'mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
    ]
];

/**
 * Class tl_functions.
 */
class tl_functions extends Backend
{
    public function getFfFunctionShortOptions(\DataContainer $dc)
    {
        $options = [];

        // Query, um Daten aus der Tabelle tl_ff_functions zu erhalten
        $result = \Database::getInstance()->prepare("SELECT id, ff_function_short FROM tl_ff_functions ORDER BY ff_function_short ASC")->execute();

        while ($result->next()) {
            $options[$result->id] = $result->ff_function_short;
        }

        return $options;
    }

    public function getFfRankShortOptions(\DataContainer $dc)
    {
        $options = [];

        // Query, um Daten aus der Tabelle tl_ff_ranks zu erhalten
        $result = \Database::getInstance()->prepare("SELECT id, ff_rank_short FROM tl_ff_ranks ORDER BY ff_rank_short ASC")->execute();

        while ($result->next()) {
            $options[$result->id] = $result->ff_rank_short;
        }

        return $options;
    }

}