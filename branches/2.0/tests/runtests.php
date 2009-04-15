<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
  define('PHPUnit_MAIN_METHOD', 'PAGET_AllTests::main');
}
require_once dirname(__FILE__) . '/paget_resourcedescription.test.php';
require_once dirname(__FILE__) . '/paget_urispace.test.php';
require_once dirname(__FILE__) . '/paget_simplepropertylabeller.test.php';
require_once dirname(__FILE__) . '/paget_simpleinferencer.test.php';
require_once dirname(__FILE__) . '/paget_form.test.php';

class PAGET_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Paget Framework Tests');

        //$suite->addTestSuite('PAGET_ResourceDescriptionTest');
        $suite->addTestSuite('PAGET_UriSpaceTest');
        $suite->addTestSuite('PAGET_SimplePropertyLabellerTest');
        $suite->addTestSuite('PAGET_SimpleInferencerTest');
        $suite->addTestSuite('PAGET_FormTest');
        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'PAGET_AllTests::main') {
    PAGET_AllTests::main();
}

?>
