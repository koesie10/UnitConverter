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
    public abstract function getName(): string;
}