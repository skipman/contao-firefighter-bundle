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

use Skipman\ContaoFirefighterBundle\Controller\FrontendModule\FfMemberListingController;

/**
 * Backend modules
 */
$GLOBALS['TL_LANG']['MOD']['firefighter_module'] = 'FIREBRIGADE';
$GLOBALS['TL_LANG']['MOD']['firefighter_collection'] = ['FF Members', 'Manage fire brigade-specific member data'];
$GLOBALS['TL_LANG']['MOD']['firefighter_functions'] = ['FF Functions', 'Manage fire brigade-specific functions'];

/**
 * Frontend modules
 */
$GLOBALS['TL_LANG']['FMD']['firefighter_module'] = 'FF Members';
$GLOBALS['TL_LANG']['FMD'][FfMemberListingController::TYPE] = ['FF Members', 'Lists the members of a fire department'];

