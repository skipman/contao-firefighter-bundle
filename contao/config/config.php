<?php

/*
 * This file is part of Contao Firefighter Bundle.
 *
 * (c) Ronald Boda 2023 <info@coboda.at>
 * @license GPL-3.0-or-later
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/skipman/contao-firefighter-bundle
 */

use Skipman\ContaoFirefighterBundle\Model\FfMembersModel;
use Skipman\ContaoFirefighterBundle\Model\FfFunctionsModel;

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['firefighter_module']['firefighter_collection'] = array(
    'tables' => array('tl_ff_members')
);
$GLOBALS['BE_MOD']['firefighter_module']['firefighter_functions'] = array(
    'tables' => array('tl_ff_functions')
);

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_ff_members'] = FfMembersModel::class;
$GLOBALS['TL_MODELS']['tl_ff_function'] = FfFunctionsModel::class;
