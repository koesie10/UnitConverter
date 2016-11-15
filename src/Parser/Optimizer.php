<?php

namespace Vlaswinkel\UnitConverter\Parser;

use Vlaswinkel\UnitConverter\Parser\AST\ASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\UnitASTNode;

class Optimizer implements OptimizerInterface {
    /**
     * This function will optimize the $node for easier parsing.
     *
     * Currently implemented optimizations:
     * - x^-2 => 1/x^2
     *
     * @param ASTNode $node
     * @return ASTNode
     */
    public function optimize(ASTNode $node): ASTNode {
        if ($node instanceof BinaryOperatorASTNode) {
            if ($node->getOperand() == '^') {
                $right = $node->getRight();
                if ($right instanceof DigitASTNode) {
                    if ($right->getValue() == 0) {
                        throw new ParseException('Invalid exponential index 0');
                    }
                    if ($right->getValue() < 0) {
                        return new BinaryOperatorASTNode(
                            '/',
                            new DigitASTNode('1'),
                            new BinaryOperatorASTNode(
                                '^',
                                $this->optimize($node->getLeft()),
                                new DigitASTNode(strval(-1 * $right->getValue()))
                            )
                        );
                    }
                }
            }

            return new BinaryOperatorASTNode(
                $node->getOperand(),
                $this->optimize($node->getLeft()),
                $this->optimize($node->getRight())
            );
        }

        return $node;
    }
}