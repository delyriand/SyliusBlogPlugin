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

namespace MonsieurBiz\SyliusBlogPlugin\Form\Type\UiElement;

use MonsieurBiz\SyliusBlogPlugin\Form\Type\CaseStudyElementType;
use MonsieurBiz\SyliusRichEditorPlugin\Attribute\AsUiElement;
use MonsieurBiz\SyliusRichEditorPlugin\Attribute\TemplatesUiElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

#[AsUiElement(
    code: 'monsieurbiz_blog.case_studies_ui_element',
    icon: 'crosshairs',
    title: 'monsieurbiz_blog.ui_element.case_studies_ui_element.title',
    description: 'monsieurbiz_blog.ui_element.case_studies_ui_element.description',
    uiElement: 'MonsieurBiz\SyliusBlogPlugin\UiElement\CaseStudiesUiElement',
    templates: new TemplatesUiElement(
        adminRender: '@MonsieurBizSyliusBlogPlugin/admin/uielement/case_studies.html.twig',
        frontRender: '@MonsieurBizSyliusBlogPlugin/shop/uielement/case_studies.html.twig',
    ),
    wireframe: 'case-studies',
    tags: ['blog', 'blog-case-studies', 'case-studies'],
)]
class CaseStudiesUiElementType extends AbstractType
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'monsieurbiz_blog.ui_element.case_studies_ui_element.fields.title',
                'required' => false,
            ])
            ->add('case_studies', LiveCollectionType::class, [
                'label' => 'monsieurbiz_blog.ui_element.case_studies_ui_element.fields.case_studies',
                'entry_type' => CaseStudyElementType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'attr' => [
                    'class' => 'row row-cols-1 row-cols-sm-2',
                ],
                'entry_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'p-3 bg-gray-300 border rounded col',
                    ],
                ],
                'constraints' => [
                    new Assert\Count(['min' => 1]),
                    new Assert\Valid(),
                ],
            ])
        ;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        usort($view['case_studies']->children, function (FormView $articleA, FormView $articleB) {
            return match (true) {
                !$articleA->offsetExists('position') => -1,
                !$articleB->offsetExists('position') => 1,
                default => $articleA['position']->vars['data'] <=> $articleB['position']->vars['data']
            };
        });
    }
}
