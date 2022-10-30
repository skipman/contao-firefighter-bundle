<?php

declare(strict_types=1);

/*
 * This file is part of Contao Firefighter Bundle.
 *
 * (c) Ronald Boda 2022 <info@coboda.at>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/skipman/contao-firefighter-bundle
 */

use Contao\Backend;
use Contao\DC_Table;
use Contao\Input;

/**
 * Table tl_ff_ranks
 */
$GLOBALS['TL_DCA']['tl_ff_ranks'] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql'              => array(
            'keys' => array(
                'id' => 'primary'
            )
        ),
    ),
    'list'        => array(
        'sorting'         => array(
            'mode'        => 2, // Sorting mode by a fixed field
            'fields'      => array('ff_rank_long'),
            'flag'        => 1, // Sort by initial letter ascending
            'panelLayout' => 'filter;sort,search,limit'
        ),
        'label'             => array(
            'fields' => array('ff_rank_long'),
            'format' => '%s'
        ),
        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations'        => array(
            'edit'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_ff_ranks']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg'
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_ff_ranks']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg'
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_ff_ranks']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'   => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_ff_ranks']['show'],
                'href'       => 'act=show',
                'icon'       => 'show.svg',
                'attributes' => 'style="margin-right:3px"'
            ),
        )
    ),
    // Palettes
    'palettes'    => array(
        'default'      => '{rank_legend},ff_rank_short,ff_rank_long,ff_rank_pic',
    ),

    // Fields
    'fields'      => array(
        'id'             => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp'         => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'ff_rank_short'          => array(
            'inputType'  => 'text',
            'exclude'    => true,
            'search'     => true,
            'filter'     => true,
        //    'sorting'    => true,
            'flag'       => 1,
            'eval'       => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'        => "varchar(255) NOT NULL default ''"
        ),
        'ff_rank_long'          => array(
            'inputType'  => 'text',
            'exclude'    => true,
            'search'     => true,
            'flag'       => 1,
            'eval'       => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'        => "varchar(255) NOT NULL default ''"
        ),
		'ff_rank_pic' => array
		(
			'exclude'    => true,
			'inputType'  => 'fileTree',
			'eval'       => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'        => "binary(16) NULL"
		)
    )
);

/**
 * Class tl_ff_ranks
 */

// Nicht benötigter CustomButton im Fußbereich
class tl_ff_ranks extends Backend
{
};


