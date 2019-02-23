<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Attributes;


class Style extends Base
{
    public function handle($attribute, $value, array $config): string
    {
        $style = [];
        foreach ($value as $prop => $propValue) {

            if (is_callable($propValue)) {
                $propValue = $propValue($config, $prop, $value, $attribute);
            }

            if ($propValue === false) {
                continue;
            }

            $style[] = $prop . ': ' . $propValue;
        }

        return ' style="' . implode(';', $style) . '"';
    }

    public function shouldHandle($attribute, $value, array $config): bool
    {
        return $attribute === 'style' && is_array($value);
    }
}