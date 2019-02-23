<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Attributes;


class BooleanAttribute extends Base
{
    public function handle($attribute, $value, array $config): string
    {
        return ' ' . $attribute;
    }

    public function shouldHandle($attribute, $value, array $config): bool
    {
        return $value === true;
    }
}