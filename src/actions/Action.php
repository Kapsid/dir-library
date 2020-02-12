<?php

namespace DirSync\actions;

/**
 * General class for action
 * Class Action
 * @author Martin Urbanczyk
 */
class Action implements ActionInterface
{
    /**
     * Passed parameters
     * @var array $params
     */
    public $params;

    /**
     * CopyAction constructor.
     * @param array $params
     */
    public function __construct(array $params){
        $this->params = $params;
        $this->doAction();
    }

    /**
     * Doing an actual Copy action
     */
    public function doAction() : void {
        // TODO
    }
}