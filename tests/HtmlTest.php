<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;

class HtmlTest extends TestCase
{
    public function testParseEmptyArray()
    {
        $this->assertEquals('', $this->html()->render([]));
    }

    public function testRenderWithJustAttributes()
    {
        $this->assertEquals('', $this->html()->render(['just' => 'attribute']));
    }

    public function testTestPassedString()
    {
        $this->assertEquals('passed string', $this->html()->render('passed string'));
    }

    public function testPassOneElement()
    {
        $this->assertEquals('<div></div>', $this->html()->render(['div']));
    }

    public function testRenderMultipleElements()
    {
        $this->assertEquals('<div></div><div></div>', $this->html()->render([
            ['div'],
            ['div']
        ]));
    }

    public function testRenderChildren()
    {
        $this->assertEquals('<div><a></a></div>', $this->html()->render(['div', [
            ['a']
        ]]));
    }

    public function testRenderTextChild()
    {
        $this->assertEquals('<div>Text child</div>', $this->html()->render(['div', 'Text child']));
    }

    public function testRenderMixTextWithElement()
    {
        $this->assertEquals('<div>Text child<div>Sub text</div></div>', $this->html()->render(['div', [
            'Text child',
            ['div', 'Sub text']
        ]]));
    }
}