<?php

namespace Odiseo\SyliusBannerPlugin\Form\Type;

use Odiseo\SyliusBannerPlugin\Model\BannerType as Type;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BannerType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('code', TextType::class, [
                'label' => 'sylius.ui.code',
            ])
            ->add('enabled', CheckboxType::class , [
                'label' => 'sylius.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => BannerTranslationType::class,
                'label' => 'odiseo_sylius_banner.form.banner.translations',
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'label' => 'odiseo_sylius_banner.form.banner.type',
            ])
            ->add('taxon', TaxonAutocompleteChoiceType::class, [
                'label' => 'odiseo_sylius_banner.form.banner.taxon',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'odiseo_sylius_banner.form.banner.channel',
            ])
        ;
    }
}