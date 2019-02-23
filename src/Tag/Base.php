<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Tag;


use ArekX\HtmlProcessor\Template;

abstract class Base
{
    /** @var Template */
    public $parent;

    public abstract function shouldHandle($template, array $config = []): bool;

    public abstract function handle($template, array $config = []): string;
}