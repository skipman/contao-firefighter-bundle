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

namespace Skipman\ContaoFirefighterBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'firefighter_elements', template: 'ce_ff_member_listing')]
class FfMemberListingController extends AbstractContentElementController
{
    public const TYPE = 'ff_member_listing';

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $template->text = $model->text;

        return $template->getResponse();
    }
}
