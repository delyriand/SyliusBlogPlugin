<?php

/*
 * This file is part of Monsieur Biz' Blog plugin for Sylius.
 *
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusBlogPlugin\Component;

use MonsieurBiz\SyliusBlogPlugin\Entity\TagInterface;
use Sylius\Bundle\UiBundle\Twig\Component\LiveCollectionTrait;
use Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponentTrait;
use Sylius\Bundle\UiBundle\Twig\Component\TemplatePropTrait;
use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;

#[AsLiveComponent]
class ArticleFormComponent
{
    use LiveCollectionTrait;

    /** @use ResourceFormComponentTrait<TagInterface> */
    use ResourceFormComponentTrait {
        initialize as public __construct;
    }

    use TemplatePropTrait;

    #[LiveAction]
    public function generateArticleSlug(SlugGeneratorInterface $slugGenerator, #[LiveArg] string $localeCode): void
    {
        $this->formValues['translations'][$localeCode]['slug'] = $slugGenerator->generate($this->formValues['translations'][$localeCode]['title']);
    }
}
