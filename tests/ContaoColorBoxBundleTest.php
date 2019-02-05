<?php

/*
 * This file is part of [package name].
 *
 * (c) John Doe
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\ColorBoxBundle\Tests;

use ErikWegner\ColorBoxBundle\ContaoColorBoxBundle;
use PHPUnit\Framework\TestCase;

class ContaoColorBoxBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoColorBoxBundle();

        $this->assertInstanceOf('Contao\ColorBoxBundle\ContaoColorBoxBundle', $bundle);
    }
}
