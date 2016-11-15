<?php

namespace Vlaswinkel\UnitConverter\Tests;

use PHPUnit\Framework\TestCase;
use Vlaswinkel\UnitConverter\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\AST\UnitASTNode;
use Vlaswinkel\UnitConverter\InputStream;
use Vlaswinkel\UnitConverter\Lexer;
use Vlaswinkel\UnitConverter\Parser;

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
                new DigitASTNode(2)
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
                    new DigitASTNode(2)
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
                            new DigitASTNode(2)
                        )
                    ),
                    new BinaryOperatorASTNode(
                        '^',
                        new UnitASTNode('s'),
                        new DigitASTNode(-3)
                    )
                ),
                new BinaryOperatorASTNode(
                    '^',
                    new UnitASTNode('A'),
                    new DigitASTNode(-2)
                )
            ),
            $node
        );
    }

    public function testOptimizedOhm() {
        $parser = $this->createParser('kg*m^2*s^-3*A^-2');

        $node = $parser->parse();

        $optimized = $parser->optimize($node);

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
                            new DigitASTNode(2)
                        )
                    ),
                    new BinaryOperatorASTNode(
                        '/',
                        new DigitASTNode(1),
                        new BinaryOperatorASTNode(
                            '^',
                            new UnitASTNode('s'),
                            new DigitASTNode(3)
                        )
                    )
                ),
                new BinaryOperatorASTNode(
                    '/',
                    new DigitASTNode(1),
                    new BinaryOperatorASTNode(
                        '^',
                        new UnitASTNode('A'),
                        new DigitASTNode(2)
                    )
                )
            ),
            $optimized
        );
    }

    private function createParser(string $expression): Parser {
        return new Parser(new Lexer(new InputStream($expression)));
    }
}