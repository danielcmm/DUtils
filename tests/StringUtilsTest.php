<?php

namespace tests;

require './vendor/autoload.php';

use DUtils\StringUtils;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase {


    public function testRemoveTags(){

        $html = <<<HTML
        <html><body><script>var x = 1;</script><div><span>test1</span><p>test2</p></div></body></html>
HTML;

        $newHtml = StringUtils::removeTags($html,['script','p']);
        $this->assertTrue(stripos($newHtml,"<script>") === FALSE);
        $this->assertTrue(stripos($newHtml,"<p>") === FALSE);

    }

}