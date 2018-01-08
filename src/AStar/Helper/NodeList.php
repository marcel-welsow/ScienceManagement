<?php

namespace AStar\Helper;

/**
 * Class NodeList
 *
 * @package AStar\Helper
 */
class NodeList implements \IteratorAggregate
{
    /** @var array $nodeList */
    private $nodeList = array();

    /**
     * @return \ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->nodeList);
    }

    /**
     * @param Node $node
     */
    public function add(Node $node)
    {
        $this->nodeList[$node->getId()] = $node;
    }

    /**
     * @param Node $node
     */
    public function remove(Node $node)
    {
        unset($this->nodeList[$node->getId()]);
    }

    /**
     * @param Node $node
     *
     * @return Node | null
     */
    public function get(Node $node)
    {
        if ($this->contains($node)) {
            return $this->nodeList[$node->getId()];
        }

        return null;
    }

    /**
     * @param Node $node
     *
     * @return bool
     */
    public function contains(Node $node) : bool
    {
        return isset($this->nodeList[$node->getId()]);
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->nodeList);
    }

    /**
     * @return Node|null
     */
    public function extractBest()
    {
        /** @var Node|null $bestNode */
        $bestNode = null;
        /** @var Node $node */
        foreach ($this->nodeList as $node) {
            if ($bestNode === null || $node->getF() < $bestNode->getF()) {
                $bestNode = $node;
            }
        }

        if ($bestNode !== null) {
            $this->remove($bestNode);
        }

        return $bestNode;
    }

    public function clear()
    {
        $this->nodeList = array();
    }
}