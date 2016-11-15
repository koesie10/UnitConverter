<?php
namespace Vlaswinkel\UnitConverter\Parser;

use Vlaswinkel\UnitConverter\Parser\AST\ASTNode;

interface OptimizerInterface {
    /**
     * This function will optimize the $node for easier parsing.
     *
     * Currently implemented optimizations:
     * - x^-2 => 1/x^2
     *
     * @param ASTNode $node
     * @return ASTNode
     */
    public function optimize(ASTNode $node) : ASTNode;
}