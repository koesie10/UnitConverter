<?php

namespace Vlaswinkel\UnitConverter\Parser;

use InvalidArgumentException;
use SplQueue;
use SplStack;

/**
 * Implementation of Shunting-Yard algorithm.
 * Used to translate infix mathematical expressions
 * to RPN mathematical expressions.
 *
 * @see http://en.wikipedia.org/wiki/Shunting-yard_algorithm
 * @author Adrean Boyadzhiev (netforce) <adrean.boyadzhiev@gmail.com>
 *
 * @see https://github.com/aboyadzhiev/php-math-parser/blob/master/src/Math/TranslationStrategy/ShuntingYard.php
 */
class ShuntingYard {
    /**
     * Translate array sequence of tokens from infix to
     * Reverse Polish notation (RPN) which representing mathematical expression.
     *
     * @param array $tokens Collection of Token intances
     * @return Token[] Collection of Token intances
     * @throws InvalidArgumentException
     */
    public static function translate(array $tokens): array {
        $operatorStack = new SplStack();
        $outputQueue   = new SplQueue();
        foreach ($tokens as $token) {
            switch ($token->getType()) {
                case Token::TYPE_DIGIT:
                    $outputQueue->enqueue($token);
                    break;
                case Token::TYPE_UNIT:
                    $outputQueue->enqueue($token);
                    break;
                case Token::TYPE_OPERATOR:
                    $o1 = $token;
                    while (self::hasOperatorInStack($operatorStack)
                        && ($o2 = $operatorStack->top())
                        && $o1->hasLowerPriority($o2)) {
                        $outputQueue->enqueue($operatorStack->pop());
                    }
                    $operatorStack->push($o1);
                    break;
                default:
                    throw new InvalidArgumentException(sprintf('Invalid token detected: %s', $token));
                    break;
            }
        }
        while (self::hasOperatorInStack($operatorStack)) {
            $outputQueue->enqueue($operatorStack->pop());
        }
        if (!$operatorStack->isEmpty()) {
            throw new InvalidArgumentException(sprintf('Mismatched parenthesis or misplaced number: %s',
                implode(' ', $tokens)));
        }
        return iterator_to_array($outputQueue);
    }

    /**
     * Determine if there is operator token in operato stack
     *
     * @return boolean
     */
    private static function hasOperatorInStack(SplStack $operatorStack) {
        $hasOperatorInStack = false;
        if (!$operatorStack->isEmpty()) {
            $top = $operatorStack->top();
            if (Token::TYPE_OPERATOR == $top->getType()) {
                $hasOperatorInStack = true;
            }
        }
        return $hasOperatorInStack;
    }
}