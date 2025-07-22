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

namespace MonsieurBiz\SyliusBlogPlugin\Twig;

use MonsieurBiz\SyliusBlogPlugin\Entity\TagInterface;
use MonsieurBiz\SyliusBlogPlugin\Repository\TagRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFunction;

final class BlogExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private TagRepositoryInterface $tagRepository,
        private LocaleContextInterface $localeContext,
        private bool $enableCaseStudies,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('monsieurbiz_blog_tags', [$this, 'getTags']),
        ];
    }

    /**
     * @return TagInterface[]
     */
    public function getTags(string $type): array
    {
        return $this->tagRepository->createEnabledListQueryBuilderByType($this->localeContext->getLocaleCode(), $type)->getQuery()->getResult();
    }

    public function getGlobals(): array
    {
        return [
            'monsieurbiz_blog_enable_case_studies' => $this->enableCaseStudies,
        ];
    }
}
