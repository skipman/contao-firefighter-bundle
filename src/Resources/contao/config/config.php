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
use Skipman\ContaoFirefighterBundle\Model\FfBadgesModel;
use Skipman\ContaoFirefighterBundle\Model\FfCoursesModel;
use Skipman\ContaoFirefighterBundle\Model\FfFunctionsModel;
use Skipman\ContaoFirefighterBundle\Model\FfAwardsModel;

/**
 * Backend modules
 */

$GLOBALS['BE_MOD']['firefighter']['ranks'] = array(
    'tables' => array('tl_ff_ranks')
);
$GLOBALS['BE_MOD']['firefighter']['badges'] = array(
    'tables' => array('tl_ff_badges')
);
$GLOBALS['BE_MOD']['firefighter']['courses'] = array(
    'tables' => array('tl_ff_courses')
);
$GLOBALS['BE_MOD']['firefighter']['functions'] = array(
    'tables' => array('tl_ff_functions')
);
$GLOBALS['BE_MOD']['firefighter']['awards'] = array(
    'tables' => array('tl_ff_awards')
);

/**
 * Models
 */

$GLOBALS['TL_MODELS']['tl_ff_ranks']     = FfRanksModel::class;
$GLOBALS['TL_MODELS']['tl_ff_badges']     = FfBadgesModel::class;
$GLOBALS['TL_MODELS']['tl_ff_courses']   = FfCoursesModel::class;
$GLOBALS['TL_MODELS']['tl_ff_functions'] = FfFunctionsModel::class;
$GLOBALS['TL_MODELS']['tl_ff_awards']    = FfAwardsModel::class;
