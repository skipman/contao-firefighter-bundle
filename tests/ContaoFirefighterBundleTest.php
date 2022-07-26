<?php

declare(strict_types=1);

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace Skipman\FirefighterBundle\Tests;

use Skipman\ContaoFirefighterBundle\ContaoFirefighterBundle;
use PHPUnit\Framework\TestCase;

class ContaoFirefighterBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new ContaoFirefighterBundle();

        $this->assertInstanceOf('Skipman\ContaoFirefighterBundle\ContaoFirefighterBundle', $bundle);
    }
}
