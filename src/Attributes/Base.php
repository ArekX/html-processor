<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Attributes;


abstract class Base
{
    public abstract function shouldHandle($attribute, $value, array $config): bool;

    public abstract function handle($attribute, $value, array $config): string;
}