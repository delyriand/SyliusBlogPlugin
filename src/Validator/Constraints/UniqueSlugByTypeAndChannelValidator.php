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

namespace MonsieurBiz\SyliusBlogPlugin\Validator\Constraints;

use MonsieurBiz\SyliusBlogPlugin\Entity\ArticleInterface;
use MonsieurBiz\SyliusBlogPlugin\Entity\ArticleTranslationInterface;
use MonsieurBiz\SyliusBlogPlugin\Repository\ArticleRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Webmozart\Assert\Assert;

final class UniqueSlugByTypeAndChannelValidator extends ConstraintValidator
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * @param mixed $value
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var ArticleInterface $value */
        Assert::isInstanceOf($value, ArticleInterface::class);
        /** @var UniqueSlugByTypeAndChannel $constraint */
        Assert::isInstanceOf($constraint, UniqueSlugByTypeAndChannel::class);

        // Check if the slug is unique for each channel and locale
        /** @var ArticleTranslationInterface $translation */
        foreach ($value->getTranslations() as $translation) {
            foreach ($value->getChannels() as $channel) {
                if ($this->articleRepository->existsOneByTypeAndChannelAndSlug(
                    (string) $translation->getSlug(),
                    (string) $translation->getLocale(),
                    $value->getType(),
                    $channel,
                    $value->getId() ? [$value] : []
                )) {
                    $this->context->buildViolation($constraint->message, [
                        '%type%' => $value->getType(),
                        '%channel%' => $channel->getCode(),
                        '%locale%' => $translation->getLocale(),
                    ])
                        ->atPath(\sprintf('translations[%s].slug', $translation->getLocale()))
                        ->addViolation()
                    ;
                }
            }
        }
    }
}
