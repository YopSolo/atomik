<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Atomik_Model_AllTests::main');
}

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../TestHelper.php';

require_once 'Atomik/Model/Descriptor/AllTests.php';
require_once 'Atomik/Model/DescriptorTest.php';
require_once 'Atomik/Model/LocatorTest.php';
require_once 'Atomik/Model/ModelsetTest.php';
require_once 'Atomik/Model/QueryTest.php';
require_once 'Atomik/Model/ReferenceArrayTest.php';

class Atomik_Model_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Atomik Framework - Atomik_Model');

        $suite->addTestSuite('Atomik_Model_LocatorTest');
        $suite->addTestSuite('Atomik_Model_ModelsetTest');
        $suite->addTestSuite('Atomik_Model_QueryTest');
        $suite->addTestSuite('Atomik_Model_ReferenceArrayTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Atomik_Model_AllTests::main') {
    Atomik_Model_AllTests::main();
}
