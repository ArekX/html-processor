<?php
/**
 * @author Aleksandar Panic
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @since 1.0.0
 **/

namespace ArekX\HtmlProcessor;

use ArekX\HtmlProcessor\Attributes\BooleanAttribute;
use ArekX\HtmlProcessor\Attributes\Classname;
use ArekX\HtmlProcessor\Attributes\HtmlAttribute;
use ArekX\HtmlProcessor\Attributes\Json;
use ArekX\HtmlProcessor\Attributes\Style;
use ArekX\HtmlProcessor\Tag\FullTag;
use ArekX\HtmlProcessor\Tag\NoSlashSelfClosingTag;
use ArekX\HtmlProcessor\Tag\SlashSelfClosingTag;

/**
 * Class Html
 * @package ArekX\HtmlProcessor
 */
class Html extends \ArekX\HtmlProcessor\Template
{
    /**
     * Html constructor.
     */
    public function __construct()
    {
        $attributeHandlers = [
            new BooleanAttribute(),
            new Classname(),
            new Json(),
            new Style(),
            new HtmlAttribute(),
        ];

        $tagHandlers = [
            new NoSlashSelfClosingTag(),
            new SlashSelfClosingTag(),
            new FullTag()
        ];

        parent::__construct($attributeHandlers, $tagHandlers);
    }
}