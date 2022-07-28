<?php

/*
 * This file is part of Contao Firefighter Bundle.
 * 
 * (c) Ronald Boda 2022 <info@coboda.at>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/skipman/contao-firefighter-bundle
 */

use Skipman\ContaoFirefighterBundle\Model\FfRanksModel;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['firefighter']['ranks'] = array(
    'tables' => array('tl_ff_ranks')
);

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_ff_ranks'] = FfRanksModel::class;
