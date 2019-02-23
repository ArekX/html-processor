<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor\Tag;


class SlashSelfClosingTag extends Base
{
    public function shouldHandle($template, array $config = []): bool
    {
        return !empty($template[0]) && $template[0][0] === '/';
    }

    public function handle($template, array $config = []): string
    {
        return '<' . substr($template[0], 1) . $this->parent->renderAttributes($template, $config) . '/>';
    }
}