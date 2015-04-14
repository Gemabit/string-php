<?php

namespace Gemabit\String\Tests;

use Gemabit\String\String;

/**
 * @covers Gemabit\String\String
 */
class StringTest extends StringBaseTestCase
{
    /**
     * @expectedException \Gemabit\String\Exception\InvalidArgumentException
     * @expectedExceptionMessage Passed value must be a string.
     */
    public function testInvalidConstruction()
    {
        new String(array('INVALID'));
    }

    public function testMagicToString()
    {
        $sentence = "Which came first, the chicken or the egg?";
        $str = new String($sentence);
        $this->assertEquals($sentence, (string) $str);
    }

    public function testToString()
    {
        $sentence = "Which came first, the chicken or the egg?";
        $str = new String($sentence);
        $this->assertEquals($sentence, $str->toString());
    }

    public function testAppend()
    {
        $str = new String("Which came first ");
        $str->append("the chicken or the egg?");
        $this->assertEquals("Which came first the chicken or the egg?", (string) $str);
    }

    public function testPrepend()
    {
        $str = new String("the chicken or the egg?");
        $str->prepend("Which came first ");
        $this->assertEquals("Which came first the chicken or the egg?", (string) $str);
    }

    public function testToUpper()
    {
        $str = new String("Which came first, the Chicken or the Egg?");
        $this->assertEquals("WHICH CAME FIRST, THE CHICKEN OR THE EGG?", $str->toUpper()->toString());

        $str = new String("which came first, the chicken or the egg?");
        $this->assertEquals("Which came first, the chicken or the egg?", $str->toUpper(true)->toString());
    }

    public function testToLower()
    {
        $str = new String("Which came first, the Chicken or the Egg?");
        $this->assertEquals("which came first, the chicken or the egg?", $str->toLower()->toString());

        $str = new String("Which came first, the Chicken or the Egg?");
        $this->assertEquals("which came first, the Chicken or the Egg?", $str->toLower(true)->toString());
    }
}
