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
class UnitConverterTest extends TestCase {
    /**
     * @var UnitConverter
     */
    private $converter;

    public static function setUpBeforeClass() {
        bcscale(20); // we want to have a reasonable scale for testing
    }

    public function setUp() {
        $this->converter = new UnitConverter();
    }

    public function testSimpleUnitConverter() {
        $this->assertEquals('3.28083989501312335958', $this->converter->convert('1', 'm', 'ft'));
    }

    public function testDerivedMile() {
        $this->assertEquals('1609.344', $this->converter->convert('1', 'mile', 'm'));
    }

    public function testDerivedShortTon() {
        $this->assertEquals('907.18474', $this->converter->convert('1', 'shortton', 'kg'));
    }

    public function testArea() {
        $this->assertEquals('10.76391041670972230833', $this->converter->convert('1', 'm^2', 'ft^2'));
    }

    public function testComplexArea() {
        $this->assertEquals('10000', $this->converter->convert('1', 'ha', 'm^2'));
    }

    public function testComplexVolume() {
        $this->assertEquals('4.54609', $this->converter->convert('1', 'impgal', 'L'));
    }

    public function testSpeed() {
        $this->assertEquals('2.23693629205440229062', $this->converter->convert('1', 'm/s', 'mi/h'));
    }

    public function testComplexUnit() {
        $this->assertEquals('1069.06636670416528910000', $this->converter->convert('10000', 'L/ha', 'usgal/ac'));
    }

    public function testDerivedWatt() {
        $this->assertEquals('1', $this->converter->convert('1', 'W', 'J/s'));
    }
}