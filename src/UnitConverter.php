<?php

namespace Vlaswinkel\UnitConverter;

use Vlaswinkel\UnitConverter\Math\Math;
use Vlaswinkel\UnitConverter\Math\MathWrapper;
use Vlaswinkel\UnitConverter\Parser\AST\ASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\BinaryOperatorASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\DigitASTNode;
use Vlaswinkel\UnitConverter\Parser\AST\UnitASTNode;
use Vlaswinkel\UnitConverter\Parser\Optimizer;
use Vlaswinkel\UnitConverter\Parser\OptimizerInterface;
use Vlaswinkel\UnitConverter\Parser\Parser;
use Vlaswinkel\UnitConverter\Units\Unit;

/**
 * Class UnitConverter
 *
 * @author  Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter
 */
class UnitConverter {
    /**
     * @var MathWrapper
     */
    private $math;

    /**
     * @var OptimizerInterface
     */
    private $optimizer;

    /**
     * UnitConverter constructor.
     * @param MathWrapper|null $math
     * @param OptimizerInterface|null $optimizer
     */
    public function __construct($math = null, $optimizer = null) {
        if (is_null($math)) {
            $math = Math::create();
        }
        $this->math = $math;

        if (is_null($optimizer)) {
            $optimizer = new Optimizer();
        }
        $this->optimizer = $optimizer;
    }

    /**
     * Converts $amount $fromUnit to $toUnit. This method will not check whether the two units
     * are compatible, i.e. defined in the same SI base units.
     *
     * @param string $amount
     * @param string $fromUnit
     * @param string $toUnit
     * @return string
     */
    public function convert(string $amount, string $fromUnit, string $toUnit): string {
        $fromParser = Parser::create($fromUnit);
        $toParser   = Parser::create($toUnit);

        $from = $fromParser->parse();
        $to   = $toParser->parse();

        $from = $this->optimizer->optimize($from);
        $to   = $this->optimizer->optimize($to);

        if ($from instanceof DigitASTNode) {
            throw new \InvalidArgumentException('Invalid from unit, it is a single integer');
        }

        if ($to instanceof DigitASTNode) {
            throw new \InvalidArgumentException('Invalid to unit, it is a single integer');
        }

        $fromFactor = $this->convertInternal($from);
        $toFactor   = $this->convertInternal($to);

        return $this->math->mul($amount, $this->math->div($fromFactor['value'], $toFactor['value']));
    }

    private function convertInternal(ASTNode $node): array {
        if ($node instanceof DigitASTNode) {
            return [
                'type' => $node->getValue(),
                'value' => $node->getValue()
            ];
        }

        if ($node instanceof UnitASTNode) {
            return $this->convertUnit($node->getValue());
        }

        if ($node instanceof BinaryOperatorASTNode) {
            $left  = $this->convertInternal($node->getLeft());
            $right = $this->convertInternal($node->getRight());

            $type = $left['type'] . $node->getOperand() . $right['type'];

            switch ($node->getOperand()) {
                case '^':
                    $value = $this->math->pow($left['value'], $right['value']);
                    break;
                case '*':
                    $value = $this->math->mul($left['value'], $right['value']);
                    break;
                case '/':
                    $value = $this->math->div($left['value'], $right['value']);

                    if ($left['type'] == $right['type']) {
                        $type = $value;
                    }

                    break;
                default:
                    throw new \InvalidArgumentException('Invalid operand ' . $node->getOperand());
            }

            return [
                'type' => $type,
                'value' => $value,
            ];
        }

        throw new \InvalidArgumentException('Unknown node ' . $node->getName());
    }

    private function convertUnit(string $unit): array {
        if (!array_key_exists($unit, Unit::units)) {
            $unitParser = Parser::create($unit);

            $node = $unitParser->parse();

            if ($node instanceof UnitASTNode) { // there is nothing more complex to be taken out of the unit
                throw new \InvalidArgumentException('Unknown unit ' . $unit);
            }

            return $this->convertInternal($node);
        }

        $unit = Unit::units[$unit];

        if (array_key_exists('base', $unit)) {
            $base = $this->convertUnit($unit['base']);
            return [
                'type' => $base['type'],
                'value' => $this->math->mul($unit['conversion'], $base['value']),
            ];
        }

        if (array_key_exists('alias', $unit)) {
            return $this->convertUnit($unit['alias']);
        }

        return [
            'type' => $unit['type'],
            'value' => '1',
        ];
    }
}