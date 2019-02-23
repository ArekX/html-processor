<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;

use ArekX\HtmlProcessor\Template;

class HtmlTagTest extends TestCase
{
    public function testSelfClosingTags()
    {
        $this->assertEquals('<div/>', $this->html()->render(['/div']));
    }

    public function testFalseIsNotRendered()
    {
        $this->assertEquals('', $this->html()->render([false]));
    }

    public function testFalseIsIgnored()
    {
        $this->assertEquals('<div><a>', $this->html()->render([['@div'], false, ['@a']]));
    }

    public function testSelfClosingTagsWithoutSlash()
    {
        $this->assertEquals('<div>', $this->html()->render(['@div']));
    }

    public function testDelegatedToTagHandlers()
    {
        $this->assertEquals('', (new Template())->render(['@div']));
    }
}