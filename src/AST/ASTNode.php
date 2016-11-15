<?php

namespace Vlaswinkel\UnitConverter\AST;

/**
 * Class ASTNode
 *
 * @author Koen Vlaswinkel <koen@vlaswinkel.info>
 * @package Vlaswinkel\UnitConverter\AST
 */
abstract class ASTNode {
    /**
     * @return string
     */
    public abstract function getName(): string;
}