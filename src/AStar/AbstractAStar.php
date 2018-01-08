<?php

namespace AStar;

use AStar\Helper\Node;

/**
 * Class AbstractAStar
 *
 * @package AStar
 */
abstract class AbstractAStar
{
    /**
     * @param Node $node
     *
     * @return array
     */
    abstract public function generateAdjacentNodes(Node $node) : array;

    /**
     * @param Node $node
     * @param Node $adjacent
     *
     * @return float
     */
    abstract public function calculateRealCost(Node $node, Node $adjacent) : float;

    /**
     * @param Node $start
     * @param Node $end
     *
     * @return float
     */
    abstract public function calculateEstimatedCost(Node $start, Node $end) : float;

    /**
     * @param Node $start
     * @param Node $end
     *
     * @return array
     */
    public function run(Node $start, Node $end)
    {
        $algorithm = new CallbackAlgorithm(
            $this,
            'generateAdjacentNodes',
            'calculateRealCost',
            'calculateEstimatedCost'
        );
        return $algorithm->runAStar($start, $end);
    }
}