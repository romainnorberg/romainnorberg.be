<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\CommonMark;

use Cocur\Slugify\Slugify;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class HeadingRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        if (!($block instanceof Heading)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $tag = 'h' . $block->getLevel();
        $attrs = $block->getData('attributes', []);

        $element = new HtmlElement($tag, $attrs, $htmlRenderer->renderInlines($block->children()));

        $id = (new Slugify())->slugify($element->getContents());

        $element->setAttribute('id', $id);
        $element->setContents(
            $element->getContents() . ' ' .
            new HtmlElement('a', ['href' => "#{$id}", 'class' => 'permalink'], '#')
        );

        return $element;
    }
}
