<?php
namespace DirSync;

use PHPUnit\Framework\TestCase;

class DirSyncTest extends TestCase{

    /**
     * Testing setting root file
     * @throws Exception
     */
    public function testSetFile() : void{
        $dirSyncObject = new DirSync();
        $dirSyncObject->fromFile('example.json');
        $this->assertEquals(
            'example.json',
            $dirSyncObject->srcFilePath
        );
    }

    /**
     * Testing setting root dir
     */
    public function testSetRootDir() : void{

        $dirSyncObject = new DirSync();
        $dirSyncObject->setRootDir('/src/folder');
        $this->assertEquals(
            '/src/folder',
            $dirSyncObject->rootDir
        );
    }

    /**
     * Testing if parsed json is array
     * @throws Exception
     */
    public function testSetJsonInput() : void{

        $dirSyncObject = new DirSync();
        $dirSyncObject->setRootDir(__DIR__.'/testFiles/example');
        $dirSyncObject->fromFile(__DIR__.'/testFiles/example.json');
        $dirSyncObject->setJsonInput();
        $this->assertInternalType("array", $dirSyncObject->jsonInput);
    }

    /**
     * Testing sync function
     * @todo Here I would compare the json structure and current dir structure based on passed options
     */
    public function testSync() : void{
        //todo
        $this->assertEquals(
            true,
            true
        );
    }
}