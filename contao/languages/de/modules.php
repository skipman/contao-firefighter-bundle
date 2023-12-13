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
$GLOBALS['TL_LANG']['MOD']['firefighter_module'] = 'FEUERWEHR';
$GLOBALS['TL_LANG']['MOD']['firefighter_members'] = ['FF Mitglieder', 'Feuerwehrspezifische Mitgliedsdaten verwalten'];
$GLOBALS['TL_LANG']['MOD']['firefighter_functions'] = ['FF Funktionen', 'Feuerwehrspezifische Funktionen verwalten'];
$GLOBALS['TL_LANG']['MOD']['firefighter_ranks'] = ['FF Dienstränge', 'Feuerwehrspezifische Dienstränge verwalten'];

/**
 * Frontend modules
 */
$GLOBALS['TL_LANG']['FMD']['firefighter_module'] = 'FF Mitglieder';
$GLOBALS['TL_LANG']['FMD'][FfMemberListingController::TYPE] = ['FF Mitglieder', 'Listet die Mitglieder einer Feuerwehr auf FE Modul'];

