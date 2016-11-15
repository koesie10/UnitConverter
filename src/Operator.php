<?php

namespace Vlaswinkel\UnitConverter;

/**
 * Class Operator
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter
 */
class Operator extends Token {
    /**
     * @var int
     */
    protected $priority;

    /**
     * Operator constructor.
     *
     * @param string $value
     * @param int $priority
     */
    public function __construct(string $value, int $priority) {
        parent::__construct(Token::TYPE_OPERATOR, $value);
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getPriority(): int {
        return $this->priority;
    }

    /**
     * Return true if this operator has lower priority than o.
     *
     * @param Operator $other
     * @return bool
     */
    public function hasLowerPriority(Operator $other): bool {
        return $this->getPriority() <= $other->getPriority();
    }
}