<?php
/**
 * @author Aleksandar Panic
 * @link https://jsonql.readthedocs.io/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace tests;

use ArekX\HtmlProcessor\Html;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function html()
    {
        return new Html();
    }
}