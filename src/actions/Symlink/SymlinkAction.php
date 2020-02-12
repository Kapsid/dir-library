<?php

namespace DirSync\actions\symlink;
use DirSync\actions\ActionInterface;
use DirSync\actions\Action;

/**
 * Class for action of symlink
 * Class SymlinkAction
 * @author Martin Urbanczyk
 */
class SymlinkAction extends Action implements ActionInterface
{
    /**
     * Passed parameters
     * @var array $params
     */
    public $params;

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