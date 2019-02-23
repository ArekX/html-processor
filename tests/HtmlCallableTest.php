<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;


use ArekX\HtmlProcessor\Template;

class HtmlCallableTest extends TestCase
{
    public function testRenderCallable()
    {
        $this->assertEquals('<tag attr="test"></tag>', $this->html()->render(function($config) {
            return ['tag', 'attr' => $config['attr']];
        }, ['attr' => 'test']));
    }


    public function testRenderCallableInArray()
    {
        $this->assertEquals('<tag1 attr="test"></tag1><tag2 attr2="test"></tag2>', $this->html()->render([
            function($config) {
                return ['tag1', 'attr' => $config['attr']];
            },
            function($config) {
                return ['tag2', 'attr2' => $config['attr']];
            }
        ], ['attr' => 'test']));
    }


    public function testRenderCallableChildren()
    {
        $this->assertEquals('<div><tag1 attr="test"></tag1><tag2 attr2="test"></tag2></div>', $this->html()->render(['div', [
            function($config) {
                return ['tag1', 'attr' => $config['attr']];
            },
            function($config) {
                return ['tag2', 'attr2' => $config['attr']];
            }
        ]], ['attr' => 'test']));
    }
}