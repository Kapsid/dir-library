<?php

namespace DirSync\actions\copy;
use DirSync\actions\ActionInterface;
use DirSync\actions\Action;

/**
 * Class for action of copying
 * Class CopyAction
 * @author Martin Urbanczyk
 */
class CopyAction extends Action implements ActionInterface
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
        parent::__construct($params);
    }

    /**
     * Overriding default action
     */
    public function doAction() : void {
        // TODO
    }
}