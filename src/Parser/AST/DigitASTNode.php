<?php

namespace Vlaswinkel\UnitConverter\Parser\AST;

/**
 * Class DigitASTNode
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Parser\AST
 */
class DigitASTNode extends ASTNode {
    const NAME = 'digit';

    /**
     * @var string
     */
    private $value;

    /**
     * DigitASTNode constructor.
     *
     * @param int $value
     */
    public function __construct(string $value) {
        $this->value = $value;
    }

    public function getName(): string {
        return self::NAME;
    }

    /**
     * @return int
     */
    public function getValue(): string {
        return $this->value;
    }
}