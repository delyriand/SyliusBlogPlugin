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

namespace MonsieurBiz\SyliusBlogPlugin\EventListener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class AdminMenuListener
{
    public function __construct(
        #[Autowire('%env(bool:MONSIEURBIZ_SYLIUS_BLOG_ENABLE_CASE_STUDIES)%')]
        private bool $enableCaseStudies,
    ) {
    }

    public function __invoke(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $blogMenu = $menu
            ->addChild('monsieurbiz-blog')
            ->setLabel('monsieurbiz_blog.ui.menu_blog')
            ->setLabelAttribute('icon', 'tabler:news')
        ;

        $blogMenu
            ->addChild('monsieurbiz-blog-tags', ['route' => 'monsieurbiz_blog_admin_tag_index', 'extras' => ['routes' => [
                'monsieurbiz_blog_admin_tag_create',
                'monsieurbiz_blog_admin_tag_update',
            ]]])
            ->setLabel('monsieurbiz_blog.ui.tags')
            ->setLabelAttribute('icon', 'tabler:layout-grid')
        ;

        $blogMenu
            ->addChild('monsieurbiz-blog-articles-blog', ['route' => 'monsieurbiz_blog_admin_article_index', 'extras' => ['routes' => [
                'monsieurbiz_blog_admin_article_create',
                'monsieurbiz_blog_admin_article_update',
            ]]])
            ->setLabel('monsieurbiz_blog.ui.articles')
            ->setLabelAttribute('icon', 'tabler:news')
        ;

        if ($this->enableCaseStudies) {
            $blogMenu
                ->addChild('monsieurbiz-blog-articles-case-study', ['route' => 'monsieurbiz_blog_admin_case_study_index', 'extras' => ['routes' => [
                    'monsieurbiz_blog_admin_case_study_create',
                    'monsieurbiz_blog_admin_case_study_update',
                ]]])
                ->setLabel('monsieurbiz_blog.ui.case_studies')
                ->setLabelAttribute('icon', 'tabler:crosshair')
            ;
        }

        $blogMenu
            ->addChild('monsieurbiz-blog-authors', ['route' => 'monsieurbiz_blog_admin_author_index', 'extras' => ['routes' => [
                'monsieurbiz_blog_admin_author_create',
                'monsieurbiz_blog_admin_author_update',
            ]]])
            ->setLabel('monsieurbiz_blog.ui.authors')
            ->setLabelAttribute('icon', 'tabler:user')
        ;
    }
}
