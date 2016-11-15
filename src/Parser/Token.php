<?php

namespace Vlaswinkel\UnitConverter\Parser;

/**
 * Class Token
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Parser
 */
class Token {
    const TYPE_UNIT = 1;
    const TYPE_OPERATOR = 2;
    const TYPE_DIGIT = 3;

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $value;

    /**
     * Token constructor.
     *
     * @param int $type
     * @param string $value
     */
    public function __construct(int $type, string $value) {
        $this->type  = $type;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue() {
        return $this->value;
    }
}