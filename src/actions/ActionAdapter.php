<?php

namespace DirSync\actions;

use DirSync\actions\remove\RemoveAction;
use DirSync\actions\symlink\SymlinkAction;
use DirSync\actions\copy\CopyAction;

/**
 * Adapter for actions
 * Class ActionAdapter
 */
class ActionAdapter implements ActionAdapterInterface
{
    /**
     * @var string $actionType
     */
    private $actionType;

    /**
     * @var array $actionParams
     */
    private $actionParams;

    /**
     * ActionAdapter constructor.
     * @param string $actionType
     * @param array $actionParams
     */
    public function __construct(string $actionType, array $actionParams) {
        $this->actionType = $actionType;
        $this->actionParams = $actionParams;
    }

    /**
     * Doing an action
     */
    public function provideAction() : Action {
        switch($this->actionType){
            case '#copy':
                return new CopyAction($this->actionParams);
            case '#symlink':
                return new SymlinkAction($this->actionParams);
            default:
                return new RemoveAction($this->actionParams);
        }
    }
}