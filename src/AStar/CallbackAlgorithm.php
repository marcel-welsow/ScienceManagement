<?php

namespace AStar;

use AStar\Helper\Node;

/**
 * Class CallbackAlgorithm
 *
 * @package AStar
 */
class CallbackAlgorithm extends AbstractAlgorithm
{
    /** @var AbstractAStar $astar */
    private $astar;
    /** @var string $adjacentNodesCallback */
    private $adjacentNodesCallback;
    /** @var string $realCostCallback */
    private $realCostCallback;
    /** @var string $estimatedCostCallback */
    private $estimatedCostCallback;

    /**
     * CallbackAlgorithm constructor.
     *
     * @param AbstractAStar $astar
     * @param string $adjacentNodesCallback
     * @param string $realCostCallback
     * @param string $estimatedCostCallback
     */
    public function __construct(AbstractAStar $astar, string $adjacentNodesCallback, string $realCostCallback, string $estimatedCostCallback)
    {
        parent::__construct();

        $this->astar = $astar;
        $this->adjacentNodesCallback = $adjacentNodesCallback;
        $this->realCostCallback = $realCostCallback;
        $this->estimatedCostCallback = $estimatedCostCallback;
    }

    /**
     * @param Node $node
     *
     * @return array
     */
    public function generateAdjacentNodes(Node $node): array
    {
        return call_user_func_array(array($this->astar, $this->adjacentNodesCallback), array($node));
    }

    /**
     * @param Node $node
     * @param Node $adjacentNode
     *
     * @return float
     */
    public function calculateRealCosts(Node $node, Node $adjacentNode): float
    {
        return call_user_func_array(array($this->astar, $this->realCostCallback), array($node, $adjacentNode));
    }

    /**
     * @param Node $start
     * @param Node $end
     *
     * @return float
     */
    public function calculateEstimatedCost(Node $start, Node $end): float
    {
        return call_user_func_array(array($this->astar, $this->estimatedCostCallback), array($start, $end));
    }
}