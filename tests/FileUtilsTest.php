<?php

namespace tests;

require './vendor/autoload.php';

use DUtils\FileUtils;
use PHPUnit\Framework\TestCase;

class FileUtilsTest extends TestCase {


    public function testFileExtension(){
        $this->assertTrue(FileUtils::getFileExtension("test1.exe.ini.csv") == "csv");
        $this->assertTrue(FileUtils::getFileExtension("test2.zipa") == "zipa");
        $this->assertTrue(FileUtils::getFileExtension(".htaccess") == "htaccess");
    }

    public function testIsCsvFile(){
        $this->assertTrue(FileUtils::isCsv("teste.csv"));
    }

    public function testIsntCsvFile(){
        $this->assertFalse(FileUtils::isCsv("teste.exe"));
    }

    public function testReadCsv(){
        $contents = FileUtils::readCsv( __DIR__ . "/test.csv",",");
        $this->assertCount(664,$contents);
    }

}