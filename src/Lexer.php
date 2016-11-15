<?php

namespace Vlaswinkel\UnitConverter;

/**
 * Class Lexer
 *
 * @author  Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter
 */
class Lexer {
    private $current = null;

    /**
     * @var InputStream
     */
    private $input;

    const arithmeticCharacters = [
        '*', '/', '^'
    ];

    /**
     * Lexer constructor.
     * @param InputStream $input
     */
    public function __construct(InputStream $input) {
        $this->input = $input;
    }

    /**
     * @return Token
     */
    public function next() {
        $token         = $this->current;
        $this->current = null;
        if ($token) {
            return $token;
        }
        return $this->readNext();
    }

    /**
     * @return bool
     */
    public function eof() {
        return $this->peek() == null;
    }

    /**
     * @return Token
     */
    public function peek() {
        if ($this->current) {
            return $this->current;
        }
        $this->current = $this->readNext();
        return $this->current;
    }

    /**
     * @param string $msg
     *
     * @throws ParseException
     */
    public function error($msg) {
        $this->input->error($msg);
    }

    /**
     * @return Token
     * @throws ParseException
     */
    protected function readNext() {
        $this->readWhile([$this, 'isWhitespace']);
        if ($this->input->eof()) {
            return null;
        }
        $char = $this->input->peek();

        if ($this->isUnitCharacter($char)) {
            return $this->readUnit();
        } else if ($this->isArithmeticCharacter($char)) {
            return $this->readArithmetic();
        } else if ($this->isDigit($char)) {
            return $this->readDigit();
        }

        $this->input->error('Cannot handle character: ' . $char . ' (ord: ' . ord($char) . ')');
    }

    /**
     * @param callable $predicate
     *
     * @return string
     */
    protected function readWhile(callable $predicate): string {
        $str = "";
        while (!$this->input->eof() && call_user_func($predicate, $this->input->peek())) {
            $str .= $this->input->next();
        }
        return $str;
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isUnitCharacter(string $char): bool {
        return preg_match('/[a-zA-Z]/', $char) === 1;
    }

    /**
     * @return Token
     */
    protected function readUnit(): Token {
        $value = $this->readWhile([$this, 'isUnitCharacter']);
        return new Token(Token::TYPE_UNIT, $value);
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isArithmeticCharacter(string $char): bool {
        return in_array($char, self::arithmeticCharacters);
    }

    /**
     * @return Token
     */
    protected function readArithmetic(): Token {
        $value = $this->input->next();
        return new Token(Token::TYPE_ARITHMETIC, $value);
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isDigit(string $char): bool {
        return ctype_digit($char) || $char == '-';
    }

    /**
     * @return Token
     */
    public function readDigit(): Token {
        $value = $this->readWhile([$this, 'isDigit']);
        return new Token(Token::TYPE_DIGIT, $value);
    }

    /**
     * @param string $char
     *
     * @return bool
     */
    protected function isWhitespace(string $char): bool {
        return strpos(" \t\n\r", $char) !== false;
    }
}