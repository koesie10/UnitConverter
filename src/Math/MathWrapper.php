<?php

namespace Vlaswinkel\UnitConverter\Math;

interface MathWrapper {
    public function add(string $left_operand, string $right_operand): string;
    public function div(string $left_operand, string $right_operand): string;
    public function mul(string $left_operand, string $right_operand): string;
    public function pow(string $left_operand, string $right_operand): string;
    public function sub(string $left_operand, string $right_operand): string;
}