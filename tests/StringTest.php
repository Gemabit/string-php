<?php

use Gemabit\String\String;

/**
 * @covers String
 */
class StringTest extends PHPUnit_Framework_TestCase
{

	public function testMagicToString()
	{
		$sentence = "Which came first, he chicken or the egg?";
		$str = new String($sentence);
		$this->assertEquals($sentence, (string) $str);
	}
}
