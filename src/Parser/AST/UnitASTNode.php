<?php

namespace Vlaswinkel\UnitConverter\Parser\AST;

/**
 * Class UnitASTNode
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Parser\AST
 */
class UnitASTNode extends ASTNode {
    const NAME = 'unit';

    /**
     * @var string
     */
    private $value;

    /**
     * UnitASTNode constructor.
     * @param string $value
     */
    public function __construct($value) {
        $this->value = $value;
    }

    public function getName(): string {
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return $this->value;
    }
}