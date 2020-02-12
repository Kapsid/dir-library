<?php

namespace DirSync\actions;

/**
 * Interface for all actions
 * Interface ActionInterface
 * @author Martin Urbanczyk
 */
interface ActionInterface
{
    /**
     * Constructor.
     * @param array $arrayParams
     */
    public function __construct(array $arrayParams);

    /**
     * Doing an actual action
     */
    public function doAction() : void;
}