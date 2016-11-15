<?php

namespace Vlaswinkel\UnitConverter\Math;

class DefaultMathWrapper implements MathWrapper {
    public function add(string $left_operand, string $right_operand): string {
        return strval(floatval($left_operand) + floatval($right_operand));
    }

    public function div(string $left_operand, string $right_operand): string {
        return strval(floatval($left_operand) / floatval($right_operand));
    }

    public function mul(string $left_operand, string $right_operand): string {
        return strval(floatval($left_operand) * floatval($right_operand));
    }

    public function pow(string $left_operand, string $right_operand): string {
        return strval(pow(floatval($left_operand), floatval($right_operand)));
    }

    public function sub(string $left_operand, string $right_operand): string {
        return strval(floatval($left_operand) - floatval($right_operand));
    }
}