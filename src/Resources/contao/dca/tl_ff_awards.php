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
 * Table tl_ff_awards
 */
$GLOBALS['TL_DCA']['tl_ff_awards'] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'sql'              => array(
            'keys' => array(
            'id' => 'primary'
            )
        )
    ),
    'edit'        => array(
        'buttons_callback' => array(
            array('tl_ff_awards', 'buttonsCallback')
        )
    ),
    'list'        => array(
        'sorting'           => array(
            'mode'        => 2,
            'fields'      => array('ff_award_short'),
            'flag'        => 1,
            'panelLayout' => 'filter;sort,search,limit'
        ),
        'label'             => array(
            'fields' => array('ff_award_short'),
            'format' => '%s',
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
                'label' => &$GLOBALS['TL_LANG']['tl_ff_awards']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg'
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_ff_awards']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.svg'
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_ff_awards']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'   => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_ff_awards']['show'],
                'href'       => 'act=show',
                'icon'       => 'show.svg',
                'attributes' => 'style="margin-right:3px"'
            ),
        )
    ),
    // Palettes
    'palettes'    => array(
        'default'      => '{award_legend},ff_award_short,ff_award_long',
    ),

    // Fields
    'fields'      => array(
        'id'             => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp'         => array(
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'ff_award_short'          => array(
            'inputType'  => 'text',
            'exclude'    => true,
            'search'     => true,
            'filter'     => true,
        //    'sorting'    => true,
            'flag'       => 1,
            'eval'       => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'        => "varchar(255) NOT NULL default ''"
        ),
        'ff_award_long'          => array(
            'inputType'  => 'text',
            'exclude'    => true,
            'search'     => true,
            'flag'       => 1,
            'eval'       => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'        => "varchar(255) NOT NULL default ''"
        )
    )
);

/**
 * Class tl_ff_awards
 */

// Nicht benötigter Button im Fußbereich 
class tl_ff_awards extends Backend
{
    /**
     * @param $arrButtons
     * @param  DC_Table $dc
     * @return mixed
     */
    public function buttonsCallback($arrButtons, DC_Table $dc)
    {
        if (Input::get('act') === 'edit')
        {
            $arrButtons['customButton'] = '<button type="submit" name="customButton" id="customButton" class="tl_submit customButton" accesskey="x">' . $GLOBALS['TL_LANG']['tl_ff_awards']['customButton'] . '</button>';
        }

        return $arrButtons;
    }
}
