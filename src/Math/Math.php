<?php

namespace Vlaswinkel\UnitConverter\Math;

class Math {
    public static function create() {
        if (extension_loaded('bcmath')) {
            return new BCMathWrapper();
        } else {
            return new DefaultMathWrapper();
        }
    }
}