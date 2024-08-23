<?php

/*
 * This file is part of Monsieur Biz's Blog plugin for Sylius.
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusBlogPlugin\Menu;

use MonsieurBiz\SyliusBlogPlugin\Entity\ArticleInterface;
use MonsieurBiz\SyliusBlogPlugin\Repository\ArticleRepositoryInterface;
use MonsieurBiz\SyliusMenuPlugin\Provider\AbstractUrlProvider;
use Symfony\Component\Routing\RouterInterface;
use Webmozart\Assert\Assert;

class BlogUrlProvider extends AbstractUrlProvider
{
    public const PROVIDER_CODE = 'blog';

    protected string $code = self::PROVIDER_CODE;

    protected string $icon = 'newspaper';

    protected int $priority = 25;

    public function __construct(
        RouterInterface $router,
        private ArticleRepositoryInterface $articleRepository,
    ) {
        parent::__construct($router);
    }

    protected function getResults(string $locale, string $search = ''): iterable
    {
        $queryBuilder = $this->articleRepository->createListQueryBuilderByType($locale, ArticleInterface::BLOG_TYPE)
            ->andWhere('ba.enabled = true')
            ->andWhere('ba.state = :state')
            ->setParameter('state', ArticleInterface::STATE_PUBLISHED)
        ;

        if (!empty($search)) {
            $queryBuilder
                ->andWhere('translation.title LIKE :search OR translation.slug LIKE :search')
                ->setParameter('search', '%' . $search . '%')
            ;
        }

        $queryBuilder->setMaxResults($this->getMaxResults());

        /** @phpstan-ignore-next-line */
        return $queryBuilder->getQuery()->getResult();
    }

    protected function addItemFromResult(object $result, string $locale): void
    {
        Assert::isInstanceOf($result, ArticleInterface::class);
        /** @var ArticleInterface $result */
        $result->setCurrentLocale($locale);
        $this->addItem(
            (string) $result->getTitle(),
            $this->router->generate('monsieurbiz_blog_article_show', ['slug' => $result->getSlug(), '_locale' => $locale])
        );
    }
}
