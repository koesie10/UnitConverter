<?php

namespace Vlaswinkel\UnitConverter\Tests;

use PHPUnit\Framework\TestCase;
use Vlaswinkel\UnitConverter\UnitConverter;

/**
 * Class UnitConverterTest
 *
 * @author  Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Tests
 */
class LuaTokenStreamTest extends TestCase {
    public function testSimpleUnitConverter() {
        $obj = new UnitConverter();

        $this->assertEquals(1.0 / 0.3048, $obj->convert(1, 'm', 'ft'));
    }
}