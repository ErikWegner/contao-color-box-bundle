<?php

/*
 * This file is part of Color Box.
 *
 * (c) Erik Wegner
 *
 * @license LGPL-3.0-or-later
 */

namespace ErikWegner\ContaoColorBoxBundle\Tests;

use ErikWegner\ContaoColorBoxBundle\ContaoColorBoxBundle;
use PHPUnit\Framework\TestCase;

class ContaoColorBoxBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new ContaoColorBoxBundle();

        $this->assertInstanceOf('ErikWegner\ContaoColorBoxBundle\ContaoColorBoxBundle', $bundle);
    }
}
