<?php

namespace Vlaswinkel\UnitConverter\AST;

class DigitASTNode extends ASTNode {
    const NAME = 'digit';

    /**
     * @var int
     */
    private $value;

    /**
     * DigitASTNode constructor.
     *
     * @param int $value
     */
    public function __construct(int $value) {
        $this->value = $value;
    }

    public function getName(): string {
        return self::NAME;
    }

    /**
     * @return int
     */
    public function getValue(): int {
        return $this->value;
    }
}