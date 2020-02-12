<?php

namespace DirSync\actions;

/**
 * Interface for action adapter
 * Interface ActionInterface
 */
interface ActionAdapterInterface
{
    /**
     * ActionAdapter constructor.
     * @param string $actionType
     * @param array $actionParams
     */
    public function __construct(string $actionType, array $actionParams);

    /**
     * Doing an action
     */
    public function provideAction() : Action;
}