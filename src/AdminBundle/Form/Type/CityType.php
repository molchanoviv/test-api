<?php
declare(strict_types = 1);

namespace AdminBundle\Form\Type;

use AdminBundle\Form\DataTransformer\RegionEntitiesToPropertyTransformer;
use AppBundle\Entity\City;
use AppBundle\Entity\Region;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

/**
 * AdminBundle\Form\Type\CityType
 *
 * @author Ivan Molchanov <molchanoviv@yandex.ru>
 */
class CityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add(
                'region',
                Select2EntityType::class,
                [
                    'remote_route' => 'find-regions',
                    'class' => Region::class,
                    'primary_key' => 'id',
                    'text_property' => 'name',
                    'transformer' => RegionEntitiesToPropertyTransformer::class,
                    'required' => false,
                    'placeholder' => 'Select a region',
                    'attr' => ['class' => 'region-selector'],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => City::class,]);
    }
}
