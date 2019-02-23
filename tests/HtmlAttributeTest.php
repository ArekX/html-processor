<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;


use ArekX\HtmlProcessor\Template;

class HtmlAttributeTest extends TestCase
{
    public function testPassingAttribute()
    {
        $this->assertEquals('<div attribute="value"></div>', $this->html()->render(['div', 'attribute' => 'value']));
    }

    public function testPassingTrueAttribute()
    {
        $this->assertEquals('<div attribute></div>', $this->html()->render(['div', 'attribute' => true]));
    }

    public function testRenderMultipleElementsWithAttributes()
    {
        $this->assertEquals('<div a="b"></div><div a2="b"></div>', $this->html()->render([
            ['div', 'a' => 'b'],
            ['div', 'a2' => 'b']
        ]));
    }

    public function testRenderChildrenWithAttributes()
    {
        $this->assertEquals('<div class="klass"><a href="#"></a></div>', $this->html()->render(['div', 'class' => 'klass', [
            ['a', 'href' => '#']
        ]]));
    }

    public function testDoNoRenderAttributesIfValuesAreFalse()
    {
        $this->assertEquals('<div></div>', $this->html()->render(['div', 'value' => false]));
    }

    public function testClassAttributeWillParseArray()
    {
        $this->assertEquals('<div class="class1 class2"></div>', $this->html()->render(['div', 'class' => ['class1', 'class2']]));
    }

    public function testClassAttributeWillParseCallabke()
    {
        $this->assertEquals('<div class="class1 class2"></div>', $this->html()->render(['div', 'class' => function($config) {
            return $config['class'];
        }], ['class' => ['class1', 'class2']]));
    }

    public function testStyleAttributeWillParseArray()
    {
        $this->assertEquals('<div style="background: #FFF"></div>', $this->html()->render(['div', 'style' => ['background' => '#FFF']]));
    }

    public function testStyleAttributeFalseWillNotBeIncluded()
    {
        $this->assertEquals('<div style=""></div>', $this->html()->render(['div', 'style' => ['background' => false]]));
    }

    public function testStyleAttributeWillParseCallable()
    {
        $this->assertEquals('<div style="background: #FFF"></div>', $this->html()->render(['div', 'style' => function($config) {
            return $config['style'];
        }], ['style' => ['background' => '#FFF']]));
    }

    public function testJsonInAttribute()
    {
        $this->assertEquals('<div data-json="{}"></div>', $this->html()->render(['div', 'data-json' => ['json', []]]));
    }

    public function testJsonValueInAttribute()
    {
        $this->assertEquals('<div data-json="{&quot;key&quot;:true}"></div>', $this->html()->render(['div', 'data-json' => ['json', ['key' => true]]]));
    }
}