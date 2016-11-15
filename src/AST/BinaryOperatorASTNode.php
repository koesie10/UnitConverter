<?php

namespace Vlaswinkel\UnitConverter\AST;

/**
 * Class BinaryOperatorASTNode
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\AST
 */
class BinaryOperatorASTNode extends ASTNode {
    const NAME = 'binary_operator';

    /**
     * @var string
     */
    private $operand;

    /**
     * @var ASTNode
     */
    private $left;
    /**
     * @var ASTNode
     */
    private $right;

    /**
     * BinaryOperatorASTNode constructor.
     * @param string $operand
     * @param ASTNode $left
     * @param ASTNode $right
     */
    public function __construct(string $operand, ASTNode $left, ASTNode $right) {
        $this->operand = $operand;
        $this->left    = $left;
        $this->right   = $right;
    }

    public function getName(): string {
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getOperand(): string {
        return $this->operand;
    }

    /**
     * @return ASTNode
     */
    public function getLeft(): ASTNode {
        return $this->left;
    }

    /**
     * @return ASTNode
     */
    public function getRight(): ASTNode {
        return $this->right;
    }
}