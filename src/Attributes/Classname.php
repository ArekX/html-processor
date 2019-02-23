<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Attributes;


class Classname extends Base
{
    public function handle($attribute, $value, array $config): string
    {
        return ' class="' . implode(' ', $value) . '"';
    }

    public function shouldHandle($attribute, $value, array $config): bool
    {
        return $attribute === 'class' && is_array($value);
    }
}