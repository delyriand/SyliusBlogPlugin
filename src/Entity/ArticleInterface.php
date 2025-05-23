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

namespace MonsieurBiz\SyliusBlogPlugin\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface ArticleInterface extends ChannelsAwareInterface, ResourceInterface, SlugAwareInterface, ToggleableInterface, TranslatableInterface, TimestampableInterface
{
    public const GRAPH = 'monsieurbiz_blog_article';

    public const TRANSITION_PUBLISH = 'publish';

    public const STATE_DRAFT = 'draft';

    public const STATE_PUBLISHED = 'published';

    public const BLOG_TYPE = 'blog';

    public const CASE_STUDY_TYPE = 'case_study';

    public const TYPES = [
        self::BLOG_TYPE,
        self::CASE_STUDY_TYPE,
    ];

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getImage(): ?string;

    public function setImage(?string $image): void;

    public function getVideo(): ?string;

    public function setVideo(?string $video): void;

    public function getThumbnailImage(): ?string;

    public function setThumbnailImage(?string $thumbnailImage): void;

    public function getContent(): ?string;

    public function setContent(string $content): void;

    public function addTag(TagInterface $tag): void;

    public function removeTag(TagInterface $tag): void;

    public function hasTag(TagInterface $tag): bool;

    /**
     * @return Collection<array-key, TagInterface>
     */
    public function getTags(): Collection;

    public function getType(): string;

    public function setType(string $type): void;

    public function getState(): string;

    public function setState(string $state): void;

    public function getPublishedAt(): ?DateTimeInterface;

    public function setPublishedAt(?DateTimeInterface $publishedAt): void;

    public function addAuthor(AuthorInterface $author): void;

    public function removeAuthor(AuthorInterface $author): void;

    public function hasAuthor(AuthorInterface $author): bool;

    /**
     * @return Collection<array-key, AuthorInterface>
     */
    public function getAuthors(): Collection;

    public function publish(): void;

    public function getMetaTitle(): ?string;

    public function setMetaTitle(?string $metaTitle): void;

    public function getMetaDescription(): ?string;

    public function setMetaDescription(?string $metaDescription): void;

    public function getMetaKeywords(): ?string;

    public function setMetaKeywords(?string $metaKeywords): void;

    public function getMetaImage(): ?string;

    public function setMetaImage(?string $metaImage): void;
}
