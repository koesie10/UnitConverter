<?php

namespace Vlaswinkel\UnitConverter\Parser\Tests;

use PHPUnit\Framework\TestCase;
use Vlaswinkel\UnitConverter\Parser\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\UnitASTNode;
use Vlaswinkel\UnitConverter\Parser\InputStream;
use Vlaswinkel\UnitConverter\Parser\Lexer;
use Vlaswinkel\UnitConverter\Parser\Parser;

/**
 * Class ParserTest
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Tests
 */
class ParserTest extends TestCase {
    public function testSingleUnit() {
        $parser = $this->createParser('kg');

        $node = $parser->parse();
        $this->assertEquals(new UnitASTNode('kg'), $node);
    }

    public function testMultipliedUnits() {
        $parser = $this->createParser('N * m');

        $node = $parser->parse();
        $this->assertEquals(
            new BinaryOperatorASTNode(
                '*',
                new UnitASTNode('N'),
                new UnitASTNode('m')
            ),
            $node
        );
    }

    public function testDividedUnits() {
        $parser = $this->createParser('m/s');

        $node = $parser->parse();
        $this->assertEquals(
            new BinaryOperatorASTNode(
                '/',
                new UnitASTNode('m'),
                new UnitASTNode('s')
            ),
            $node
        );
    }

    public function testExponentialUnit() {
        $parser = $this->createParser('m^2');

        $node = $parser->parse();
        $this->assertEquals(
            new BinaryOperatorASTNode(
                '^',
                new UnitASTNode('m'),
                new DigitASTNode('2')
            ),
            $node
        );
    }

    public function testExponentialUnits() {
        $parser = $this->createParser('m^2/s');

        $node = $parser->parse();

        $this->assertEquals(
            new BinaryOperatorASTNode(
                '/',
                new BinaryOperatorASTNode(
                    '^',
                    new UnitASTNode('m'),
                    new DigitASTNode('2')
                ),
                new UnitASTNode('s')
            ),
            $node
        );
    }

    public function testOhm() {
        $parser = $this->createParser('kg*m^2*s^-3*A^-2');

        $node = $parser->parse();
        $this->assertEquals(
            new BinaryOperatorASTNode(
                '*',
                new BinaryOperatorASTNode(
                    '*',
                    new BinaryOperatorASTNode(
                        '*',
                        new UnitASTNode('kg'),
                        new BinaryOperatorASTNode(
                            '^',
                            new UnitASTNode('m'),
                            new DigitASTNode('2')
                        )
                    ),
                    new BinaryOperatorASTNode(
                        '^',
                        new UnitASTNode('s'),
                        new DigitASTNode('-3')
                    )
                ),
                new BinaryOperatorASTNode(
                    '^',
                    new UnitASTNode('A'),
                    new DigitASTNode('-2')
                )
            ),
            $node
        );
    }

    private function createParser(string $expression): Parser {
        return new Parser(new Lexer(new InputStream($expression)));
    }
}