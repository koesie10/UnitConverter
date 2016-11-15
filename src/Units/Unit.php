<?php

namespace Vlaswinkel\UnitConverter\Units;

/**
 * Class Unit
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Units
 */
class Unit {
    /**
     * This defines all units.
     *
     * All units are based on the SI base units.
     *
     * @see https://en.wikipedia.org/wiki/International_System_of_Units
     */
    const units = [
        // length
        'm' => ['type' => 'length'],
        'meter' => ['alias' => 'm'],
        'km' => ['base' => 'm', 'conversion' => '1000'],
        'kilometer' => ['alias' => 'km'],
        'dm' => ['base' => 'm', 'conversion' => '0.1'],
        'decimeter' => ['alias' => 'dm'],
        'cm' => ['base' => 'm', 'conversion' => '0.01'],
        'centimeter' => ['alias' => 'cm'],
        'mm' => ['base' => 'm', 'conversion' => '0.001'],
        'millimeter' => ['alias' => 'mm'],
        'μm' => ['base' => 'm', 'conversion' => '0.000001'],
        'micrometer' => ['alias' => 'μm'],
        'nm' => ['base' => 'nm', 'conversion' => '0.000000001'],
        'nanometer' => ['alias' => 'nm'],
        'pm' => ['base' => 'm', 'conversion' => '0.000000000001'],
        'picometer' => ['alias' => 'pm'],
        'in' => ['base' => 'mm', 'conversion' => '25.4'],
        'inch' => ['alias' => 'in'],
        'ft' => ['base' => 'inch', 'conversion' => '12'],
        'feet' => ['alias' => 'ft'],
        'yd' => ['base' => 'ft', 'conversion' => '3'],
        'yard' => ['alias' => 'yd'],
        'mi' => ['base' => 'yard', 'conversion' => '1760'],
        'mile' => ['alias' => 'mi'],
        'ly' => ['base' => 'm', 'conversion' => '9460730472580800'],
        'au' => ['base' => 'm', 'conversion' => '149597870700'],

        // area
        'ha' => ['base' => 'm^2', 'conversion' => '10000'],
        'hectare' => ['alias' => 'ha'],
        'ac' => ['base' => 'ft^2', 'conversion' => '43560'],

        // volume
        'L' => ['base' => 'dm^3', 'conversion' => '1'],
        'l' => ['alias' => 'L'],
        'mL' => ['base' => 'cm^3', 'conversion' => '1'],
        'ml' => ['alias' => 'mL'],
        'usgal' => ['base' => 'in^3', 'conversion' => '231'],
        'impgal' => ['base' => 'l', 'conversion' => '4.54609'],
        'uspt' => ['base' => 'usgal', 'conversion' => '0.125'],
        'imppt' => ['base' => 'impgal', 'conversion' => '0.125'],

        // weight
        'kg' => ['type' => 'weight'],
        'g' => ['base' => 'kg', 'conversion' => '0.001'],
        'mg' => ['base' => 'kg', 'conversion' => '0.000001'],
        't' => ['base' => 'kg', 'conversion' => '1000'],
        'tonne' => ['alias' => 't'],
        'shortton' => ['base' => 'lbs', 'conversion' => '2000'],
        'longton' => ['base' => 'lbs', 'conversion' => '2240'],
        'lb' => ['base' => 'kg', 'conversion' => '0.45359237'],
        'lbs' => ['alias' => 'lb'],
        'oz' => ['base' => 'lb', 'conversion' => '0.0625'],

        // time
        's' => ['type' => 'time'],
        'second' => ['alias' => 's'],
        'min' => ['base' => 's', 'conversion' => '60'],
        'minute' => ['alias' => 'min'],
        'h' => ['base' => 's', 'conversion' => '3600'],
        'hr' => ['alias' => 'h'],
        'hour' => ['alias' => 'h'],

        // other base units
        'A' => ['type' => 'electric_current'],
        'K' => ['type' => 'temperature'],
        'mol' => ['type' => 'substance_amount'],
        'cd' => ['type' => 'luminous_intensity'],

        // derived units
        'Hz' => ['base' => 's^-1', 'conversion' => '1'], // Hertz
        'N' => ['base' => 'kg*m*s^-2', 'conversion' => '1'], // Newton
        'Pa' => ['base' => 'kg*m^-1*s^-2', 'conversion' => '1'], // Pascal
        'J' => ['base' => 'kg*m^2*s^-2', 'conversion' => '1'], // Joule
        'W' => ['base' => 'kg*m^2*s^-3', 'conversion' => '1'], // Watt
        'C' => ['base' => 's*A', 'conversion' => '1'], // Coulomb
        'Ω' => ['base' => 'kg*m^2*s^-3*A^-2', 'conversion' => '1'], // Ohm
    ];
}