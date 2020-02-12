<?php

namespace DirSync\helpers;

use DirSync\actions\ActionAdapter;

/**
 * Helper for work with classes
 * Class ActionsHelper
 * @package DirSync\helpers
 * @author Martin Urbanczyk
 */
class ActionsHelper
{

    /**
     * Parsing actions from actual array
     * @param $actualJsonArray
     * @return array
     */
    public static function parseActions($actualJsonArray) : array {
        foreach(array_keys($actualJsonArray) as $key){
            if(strpos($key, '#') !== false){

                $action = new ActionAdapter($key,$actualJsonArray[$key]);

                // Here you can dump the action object Debugger::barDump($action->provideAction(),'action');

                // Removing the key from directory tree
                unset($actualJsonArray[$key]);
            }
        }

        return $actualJsonArray;
    }

}