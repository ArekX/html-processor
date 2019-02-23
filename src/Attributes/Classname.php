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
        $results = [];
        foreach ($value as $valueItem) {

            if (is_callable($valueItem)) {
                $valueItem = $valueItem($config, $attribute, $value);
            }

            if ($valueItem !== false) {
                $results[] = $valueItem;
            }
        }

        return ' class="' . implode(' ', $results) . '"';
    }

    public function shouldHandle($attribute, $value, array $config): bool
    {
        return $attribute === 'class' && is_array($value);
    }
}