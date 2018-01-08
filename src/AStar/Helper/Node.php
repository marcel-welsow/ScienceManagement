<?php

namespace AStar\Helper;

/**
 * Interface Node
 *
 * @package AStar\Helper
 */
interface Node
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param Node $node
     */
    public function setParent(Node $node);

    /**
     * @return Node | null
     */
    public function getParent();

    /**
     * @return float
     */
    public function getF() : float ;

    /**
     * @param float $score
     */
    public function setG(float $score);

    /**
     * @return float
     */
    public function getG() : float;

    /**
     * @param float $score
     */
    public function setH(float $score);

    /**
     * @return float
     */
    public function getH() : float;
}