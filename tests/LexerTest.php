<?php

namespace Vlaswinkel\UnitConverter\Tests;

use PHPUnit\Framework\TestCase;
use Vlaswinkel\UnitConverter\InputStream;
use Vlaswinkel\UnitConverter\Lexer;
use Vlaswinkel\UnitConverter\Token;

/**
 * Class LexerTest
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Tests
 */
class LexerTest extends TestCase {
    public function testSingleUnit() {
        $lexer = $this->createLexer('kg');

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'kg'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    public function testSingleUnitWithWhitespace() {
        $lexer = $this->createLexer(" m \t\n");

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'm'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    public function testMultipliedUnits() {
        $lexer = $this->createLexer('N * m');

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'N'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '*'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_UNIT, 'm'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    public function testDividedUnits() {
        $lexer = $this->createLexer('m/s');

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'm'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '/'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_UNIT, 's'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    public function testExponentialUnit() {
        $lexer = $this->createLexer('m^2');

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'm'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '^'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_DIGIT, '2'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    public function testExponentialUnits() {
        $lexer = $this->createLexer('m^2/s');

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'm'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '^'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_DIGIT, '2'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '/'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_UNIT, 's'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    public function testOhm() {
        $lexer = $this->createLexer('kg*m^2*s^-3*A^-2');

        $this->assertEquals(new Token(Token::TYPE_UNIT, 'kg'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '*'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_UNIT, 'm'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '^'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_DIGIT, '2'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '*'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_UNIT, 's'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '^'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_DIGIT, '-3'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '*'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_UNIT, 'A'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_ARITHMETIC, '^'), $lexer->next());
        $this->assertEquals(new Token(Token::TYPE_DIGIT, '-2'), $lexer->next());
        $this->assertTrue($lexer->eof());
    }

    private function createLexer(string $expression): Lexer {
        return new Lexer(new InputStream($expression));
    }
}