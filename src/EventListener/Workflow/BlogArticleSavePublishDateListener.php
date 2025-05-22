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

namespace MonsieurBiz\SyliusBlogPlugin\EventListener\Workflow;

use MonsieurBiz\SyliusBlogPlugin\Entity\ArticleInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Workflow\Event\CompletedEvent;
use Webmozart\Assert\Assert;

#[AsEventListener(
    event: 'workflow.monsieurbiz_blog_article.completed.publish'
)]
final class BlogArticleSavePublishDateListener
{
    public function __invoke(CompletedEvent $event): void
    {
        $article = $event->getSubject();
        Assert::isInstanceOf($article, ArticleInterface::class);

        $article->publish();
    }
}
