<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Attributes;


class Json extends Base
{
    public function handle($attribute, $value, array $config): string
    {
        return ' ' . $attribute . '="' . htmlentities(!empty($value['json']) ? json_encode($value['json']) : '{}') . '"';
    }

    public function shouldHandle($attribute, $value, array $config): bool
    {
        return is_array($value) && array_key_exists('json', $value);
    }
}