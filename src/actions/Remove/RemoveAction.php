<?php

namespace DirSync\actions\remove;
use DirSync\actions\ActionInterface;
use DirSync\actions\Action;

/**
 * Class for action of removing
 * Class RemoveAction
 * @author Martin Urbanczyk
 */
class RemoveAction extends Action implements ActionInterface
{
    /**
     * Passed parameters
     * @var array $params
     */
    public $params;

    /**
     * RemoveAction constructor.
     * @param array $params
     */
    public function __construct(array $params){
        parent::__construct($params);
    }

    /**
     * Overriding default action
     */
    public function doAction() : void {
        // TODO
    }
}