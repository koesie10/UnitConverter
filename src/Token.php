<?php

namespace Vlaswinkel\UnitConverter;

/**
 * Class Token
 *
 * @author  Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter
 */
class Token {
    const TYPE_UNIT = 1;
    const TYPE_ARITHMETIC = 2;
    const TYPE_DIGIT = 3;

    /**
     * @var int
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * Token constructor.
     *
     * @param int $type
     * @param string $value
     */
    public function __construct(int $type, $value) {
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