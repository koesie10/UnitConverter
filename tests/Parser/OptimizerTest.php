<?php

namespace Vlaswinkel\UnitConverter\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Vlaswinkel\UnitConverter\Parser\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\UnitASTNode;
use Vlaswinkel\UnitConverter\Parser\Optimizer;

class OptimizerTest extends TestCase {
    public function testOptimizedOhm() {
        $node = new BinaryOperatorASTNode(
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
        );

        $optimizer = new Optimizer();

        $optimized = $optimizer->optimize($node);

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
}