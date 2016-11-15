<?php

namespace Vlaswinkel\UnitConverter;

/**
 * Class InputStream
 *
 * @author  Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter
 */
class InputStream {
    /**
     * @var string
     */
    private $input;
    /**
     * @var int
     */
    private $position = 0;
    /**
     * @var int
     */
    private $line = 1;
    /**
     * @var int
     */
    private $column = 1;

    /**
     * InputStream constructor.
     *
     * @param string $input
     */
    public function __construct($input) {
        $this->input = $input;
    }

    public function next() {
        $char = $this->input[$this->position++];
        if ($char == "\n") {
            $this->line++;
            $this->column = 1;
        } else {
            $this->column++;
        }
        return $char;
    }

    public function peek($pos = 0) {
        if ($this->eof($pos)) {
            $this->error('Unexpected end of input');
        }
        return $this->input[$this->position + $pos];
    }

    public function eof($pos = 0) {
        return $this->position + $pos >= strlen($this->input);
    }

    public function error($msg) {
        throw new ParseException($msg . ' (' . $this->line . ':' . $this->column . ')');
    }
}