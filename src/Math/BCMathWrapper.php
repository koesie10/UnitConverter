<?php

namespace Vlaswinkel\UnitConverter\Math;

class BCMathWrapper implements MathWrapper {
    public function __construct() {
        if ($this->get_bscale() < 3) {
            trigger_error(
                'It is recommended to set the bscale value to at least 3 for best results for UnitConverter',
                E_USER_WARNING
            );
        }
    }

    public function add(string $left_operand, string $right_operand): string {
        return bcadd($left_operand, $right_operand);
    }

    public function div(string $left_operand, string $right_operand): string {
        return bcdiv($left_operand, $right_operand);
    }

    public function mul(string $left_operand, string $right_operand): string {
        return bcmul($left_operand, $right_operand);
    }

    public function pow(string $left_operand, string $right_operand): string {
        return bcpow($left_operand, $right_operand);
    }

    public function sub(string $left_operand, string $right_operand): string {
        return bcsub($left_operand, $right_operand);
    }

    // http://stackoverflow.com/a/19863389/1608780
    public function get_bscale() {
        $sqrt = bcsqrt('2');
        return strlen(substr($sqrt, strpos($sqrt, '.') + 1));
    }
}