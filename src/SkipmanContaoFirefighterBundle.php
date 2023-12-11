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

namespace Skipman\ContaoFirefighterBundle;

use Skipman\ContaoFirefighterBundle\DependencyInjection\SkipmanContaoFirefighterExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SkipmanContaoFirefighterBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): SkipmanContaoFirefighterExtension
    {
        return new SkipmanContaoFirefighterExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }
}
