Dir library

Version: 0.2.3

Put: "kapsid/dir-sync": "^0.2"

Some parts are unfinished, I just tried to put there some comments what could be done.

Currently full sync with no options is working (and it also separates actions from json a try to do the action).

Example usage (e.g. in Nette component:

$dirSync = new DirSync();
$dirSync->setRootDir(__DIR__.'/example');
$dirSync->fromFile(__DIR__.'/test.json');
$dirSync->setJsonInput();
$dirSync->sync();

All files and directories (/example and test.json must exist already).
