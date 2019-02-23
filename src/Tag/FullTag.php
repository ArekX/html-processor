<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Tag;


class FullTag extends Base
{
    public function shouldHandle($template, array $config = []): bool
    {
        return !empty($template[0]) && is_string($template[0]);
    }

    public function handle($template, array $config = []): string
    {
        return '<' . $template[0] . $this->parent->renderAttributes($template, $config) . '>'
            . $this->parent->renderChildren($template, $config)
            . '</' . $template[0] . '>';
    }
}