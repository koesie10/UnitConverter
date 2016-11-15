<?php

namespace Vlaswinkel\UnitConverter\Parser\AST;

/**
 * Class ASTNode
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\Parser\AST
 */
abstract class ASTNode {
    /**
     * @return string
     */
    abstract public function getName(): string;
}