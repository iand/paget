<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
  define('PHPUnit_MAIN_METHOD', 'PAGET_AllTests::main');
}
if (!defined('MORIARTY_PHPUNIT_DIR')) define('MORIARTY_PHPUNIT_DIR', '/home/iand/web/sharedpast.com/www/php/lib/phpunit/');
if (!defined('MORIARTY_DIR')) define('MORIARTY_DIR', '/home/iand/wip/n2/moriarty/trunk/');
if (!defined('MORIARTY_TEST_DIR')) define('MORIARTY_TEST_DIR', MORIARTY_DIR . 'tests/');

if (!defined('PAGET_TEST_DIR')) define('PAGET_TEST_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
if (!defined('PAGET_DIR')) define('PAGET_DIR', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);


echo "Running tests using\nMORIARTY_PHPUNIT_DIR=" . MORIARTY_PHPUNIT_DIR . "\nMORIARTY_TEST_DIR=" . MORIARTY_TEST_DIR . "\nPAGET_TEST_DIR=" . PAGET_TEST_DIR . "\n";

ini_set('include_path',
  ini_get('include_path')
  .PATH_SEPARATOR.MORIARTY_PHPUNIT_DIR
);
require_once MORIARTY_PHPUNIT_DIR . 'PHPUnit' . DIRECTORY_SEPARATOR . 'Framework.php';
require_once MORIARTY_PHPUNIT_DIR . 'PHPUnit' . DIRECTORY_SEPARATOR . 'TextUI' . DIRECTORY_SEPARATOR . 'TestRunner.php';

require_once MORIARTY_TEST_DIR . 'fakehttprequest.class.php';
require_once MORIARTY_TEST_DIR . 'fakerequestfactory.class.php';

require_once PAGET_TEST_DIR . 'PAGET_resourcedescription.test.php';


error_reporting(E_ALL );
function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}
set_error_handler('exceptions_error_handler');

function debug_exception_handler($ex) {
  echo "Error : ".$ex->getMessage()."\n";
  echo "Code : ".$ex->getCode()."\n";
  echo "File : ".$ex->getFile()."\n";
  echo "Line : ".$ex->getLine()."\n";
  echo $ex->getTraceAsString()."\n";
  exit;
}
set_exception_handler('debug_exception_handler');


class PAGET_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Paget Framework Tests');

        $suite->addTestSuite('PAGET_ResourceDescriptionTest');
        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'PAGET_AllTests::main') {
    PAGET_AllTests::main();
}

?>
