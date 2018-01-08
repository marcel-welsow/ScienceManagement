<?php

namespace AStar\Helper;

/**
 * Class AbtractNode
 *
 * @package AStar\Helper
 */
abstract class AbtractNode implements Node
{
    /** @var Node $parent */
    private $parent;
    /** @var array $children */
    private $children = array();
    /** @var float $gScore */
    private $gScore;
    /** @var float $hScore */
    private $hScore;

    /**
     * @param Node $node
     */
    public function setParent(Node $node)
    {
        $this->parent = $node;
    }

    /**
     * @return Node
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Node $node
     */
    public function addChild(Node $node)
    {
        $node->setParent($this);

        $this->children[] = $node;
    }

    /**
     * @return array
     */
    public function getChildren() : array
    {
        return $this->children;
    }

    /**
     * @return float
     */
    public function getF(): float
    {
        return $this->getG() + $this->getH();
    }

    /**
     * @param float $score
     */
    public function setG(float $score)
    {
        $this->gScore = $score;
    }

    /**
     * @return float
     */
    public function getG(): float
    {
        return $this->gScore;
    }

    /**
     * @param float $score
     */
    public function setH(float $score)
    {
        $this->hScore = $score;
    }

    /**
     * @return float
     */
    public function getH(): float
    {
        return $this->hScore;
    }
}