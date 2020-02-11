<?php
namespace DirSync;

use PHPUnit\Framework\TestCase;

class DirSyncTest extends TestCase{

    public $dirSyncObject;

    public function __construct()
    {
        $this->dirSyncObject = new DirSync();
    }

    /**
     * Testing setting root file
     * @throws Exception
     */
    public function testSetFile() : void{
        $this->dirSyncObject->fromFile('example.json');
        $this->assertEquals(
            'example.json',
            $this->dirSyncObject->rootDir
        );
    }
}