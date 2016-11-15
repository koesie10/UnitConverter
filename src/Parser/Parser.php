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
                    $stack->push(new DigitASTNode($token->getValue()));
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

    public static function create($unit): Parser {
        return new Parser(new Lexer(new InputStream($unit)));
    }
}