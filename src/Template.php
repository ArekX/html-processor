<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor;

use ArekX\HtmlProcessor\Attributes\Base as AttributeBase;
use ArekX\HtmlProcessor\Tag\Base as TagBase;

/**
 * Class Template
 * @package ArekX\HtmlProcessor
 */
class Template
{
    /** @var AttributeBase[] */
    protected $attributeHandlers = [];

    /** @var TagBase[] */
    protected $tagHandlers = [];


    /**
     * Template constructor.
     * @param array $attributeHandlers
     * @param array $tagHandlers
     */
    public function __construct($attributeHandlers = [], $tagHandlers = [])
    {
        $this->attributeHandlers = $attributeHandlers;
        $this->tagHandlers = $tagHandlers;

        foreach ($attributeHandlers as $handler) {
            $handler->parent = $this;
        }

        foreach ($tagHandlers as $handler) {
            $handler->parent = $this;
        }
    }

    /**
     * Performs rendering of html array template.
     *
     * @param array|string $template
     * @param array $config
     * @return string
     */
    public function render($template, array $config = []): string
    {
        if (is_array($template)) {
            $template = array_filter($template);
        }

        if (empty($template)) {
            return '';
        }

        if (is_string($template)) {
            return $template;
        }

        if (is_callable($template)) {
            return $this->render($template($config), $config);
        }

        if (is_array($template) && !empty($template[0]) && is_callable($template[0])) {
            $template[0] = $template[0]($config);
        }

        if (is_array($template) && !empty($template[0]) && is_array($template[0])) {
            return $this->renderArray($template, $config);
        }

        return $this->renderTag($template, $config);
    }

    /**
     * Renders children array templates
     *
     * @param array|string $template
     * @param array $config
     * @return string
     */
    public function renderChildren($template, array $config = []): string
    {
        if (empty($template[1])) {
            return '';
        }

        if (is_string($template[1])) {
            return $template[1];
        }

        return $this->renderArray($template[1], $config);
    }

    /**
     * Renders array items for template.
     *
     * @param $template
     * @param array $config
     * @return string
     */
    public function renderArray($template, array $config = []): string
    {
        $children = '';

        foreach ($template as $item) {
            $children .= $this->render($item, $config);
        }

        return $children;
    }

    /**
     * Render attributes.
     *
     * @param array $template
     * @param array $config
     * @return string
     */
    public function renderAttributes(array $template, array $config = []): string
    {
        $attributes = '';

        foreach ($template as $attribute => $value) {
            if ($attribute === 0 || $attribute === 1 || $value === false) {
                continue;
            }

            if (is_callable($value)) {
                $value = $value($config, $attribute);
            }

            foreach ($this->attributeHandlers as $handler) {
                if ($handler->shouldHandle($attribute, $value, $config)) {
                    $attributes .= $handler->handle($attribute, $value, $config);
                    continue 2;
                }
            }
        }

        return $attributes;
    }

    /**
     * Renders single tag.
     *
     * @param array $template
     * @param array $config
     * @return string
     */
    public function renderTag(array $template, array $config): string
    {
        foreach ($this->tagHandlers as $tagHandler) {
            if ($tagHandler->shouldHandle($template, $config)) {
                return $tagHandler->handle($template, $config);
            }
        }

        return '';
    }
}