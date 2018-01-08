<?php

namespace AStar;

use AStar\Helper\Node;
use AStar\Helper\NodeList;

/**
 * Class AbstractAlgorithm
 *
 * @package AStar
 */
abstract class AbstractAlgorithm
{
    /** @var NodeList $openList  */
    private $openList;
    /** @var NodeList $closedList */
    private $closedList;

    /**
     * AbstractAlgorithm constructor.
     */
    public function __construct()
    {
        $this->openList = new NodeList();
        $this->closedList = new NodeList();
    }

    /**
     * @param Node $node
     *
     * @return array
     */
    abstract public function generateAdjacentNodes(Node $node) : array ;

    /**
     * @param Node $node
     * @param Node $adjacentNode
     *
     * @return float
     */
    abstract public function calculateRealCosts(Node $node, Node $adjacentNode) : float;

    /**
     * @param Node $start
     * @param Node $end
     *
     * @return float
     */
    abstract public function calculateEstimatedCost(Node $start, Node $end) : float;

    /**
     * @return NodeList
     */
    public function getOpenList() : NodeList
    {
        return $this->openList;
    }

    /**
     * @return NodeList
     */
    public function getClosedList() : NodeList
    {
        return $this->closedList;
    }

    public function clear()
    {
        $this->getOpenList()->clear();
        $this->getClosedList()->clear();
    }

    /**
     * @param Node $start
     * @param Node $end
     *
     * @return array
     */
    public function runAStar(Node $start, Node $end) : array
    {
        /** @var array $path */
        $path = array();

        $this->clear();

        $start->setG(0);
        $start->setH($this->calculateEstimatedCost($start, $end));

        $this->getOpenList()->add($start);

        while (!$this->getOpenList()->isEmpty()) {
            /** @var Node $currentNode */
            $currentNode = $this->getOpenList()->extractBest();

            $this->getClosedList()->add($currentNode);

            if ($currentNode->getId() === $end->getId()) {
                $path = $this->generatePathFromStartNodeTo($currentNode);
                break;
            }
            /** @var array $successors */
            $successors = $this->computeAdjacentNodes($currentNode, $end);
            /** @var Node $successor */
            foreach ($successors as $successor) {
                if ($this->getOpenList()->contains($successor)) {
                    /** @var Node $successorInOpenList */
                    $successorInOpenList = $this->getOpenList()->get($successor);

                    if ($successor->getG() >= $successorInOpenList->getG()) continue;
                }

                if ($this->getClosedList()->contains($successor)) {
                    /** @var Node $successorInClosedList */
                    $successorInClosedList = $this->getClosedList()->get($successor);

                    if ($successor->getG() >= $successorInClosedList->getG()) continue;
                }

                $successor->setParent($currentNode);

                $this->getClosedList()->remove($successor);
                $this->getOpenList()->add($successor);
            }
        }

        return $path;
    }

    /**
     * @param Node $node
     *
     * @return array
     */
    private function generatePathFromStartNodeTo(Node $node) : array
    {
        /** @var array $path */
        $path = array();
        /** @var Node $currentNode */
        $currentNode = $node;

        while ($currentNode !== null) {
            array_unshift($path, $currentNode);
            /** @var Node $currentNode */
            $currentNode = $currentNode->getParent();
        }

        return $path;
    }

    /**
     * @param Node $node
     * @param Node $end
     *
     * @return array
     */
    private function computeAdjacentNodes(Node $node, Node $end) : array
    {
        /** @var array $nodes */
        $nodes = $this->generateAdjacentNodes($node);
        /** @var Node $adjacentNode */
        foreach ($nodes as $adjacentNode) {
            $adjacentNode->setG($node->getG() + $this->calculateRealCosts($node, $adjacentNode));
            $adjacentNode->setH($this->calculateEstimatedCost($adjacentNode, $end));
        }

        return $nodes;
    }
}