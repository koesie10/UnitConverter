<?php

namespace Vlaswinkel\UnitConverter\Parser;

use Vlaswinkel\UnitConverter\Parser\AST\ASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\UnitASTNode;

class ASTPrinter {
    public static function prettyPrint(ASTNode $node): string {
        $result = '';
        if ($node instanceof DigitASTNode) {
            $result .= $node->getValue();
        } else {
            if ($node instanceof UnitASTNode) {
                $result .= $node->getValue();
            } else {
                if ($node instanceof BinaryOperatorASTNode) {
                    $result .= self::prettyPrint($node->getLeft());
                    $result .= $node->getOperand();
                    $result .= self::prettyPrint($node->getRight());
                }
            }
        }

        return $result;
    }

    public static function debugPrint(ASTNode $node): string {
        var_dump($node, true);
        return '';
    }
}