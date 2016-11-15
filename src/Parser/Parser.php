<?php

namespace Vlaswinkel\UnitConverter\Parser;

use SplStack;
use Vlaswinkel\UnitConverter\Parser\AST\ASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\UnitASTNode;

/**
 * Class Parser
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Parser
 */
class Parser {
    /**
     * @var Lexer
     */
    private $lexer;

    /**
     * Parser constructor.
     *
     * @param Lexer $lexer
     */
    public function __construct(Lexer $lexer) {
        $this->lexer = $lexer;
    }

    /**
     * @return ASTNode
     */
    public function parse(): ASTNode {
        $tokens = $this->lexer->tokenize();

        $transformedTokens = ShuntingYard::translate($tokens);

        $stack = new SplStack();

        foreach ($transformedTokens as $token) {
            switch ($token->getType()) {
                case Token::TYPE_DIGIT:
                    $stack->push(new DigitASTNode(intval($token->getValue())));
                    break;
                case Token::TYPE_UNIT:
                    $stack->push(new UnitASTNode($token->getValue()));
                    break;
                case Token::TYPE_OPERATOR:
                    $n = $stack->pop();
                    $stack->push(new BinaryOperatorASTNode($token->getValue(), $stack->pop(), $n));
                    break;
            }
        }

        return $stack->top();
    }

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
                            new DigitASTNode(1),
                            new BinaryOperatorASTNode(
                                '^',
                                $this->optimize($node->getLeft()),
                                new DigitASTNode(-1 * $right->getValue())
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