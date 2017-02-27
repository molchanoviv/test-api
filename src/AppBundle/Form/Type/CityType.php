<?php
declare(strict_types = 1);

namespace AppBundle\Form\Type;

use AppBundle\Entity\City;
use AppBundle\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * AppBundle\Form\Type\CityType
 *
 * @author Ivan Molchanov <ivan.molchanov@yandex.ru>
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
            ->add('id', NumberType::class, ['mapped' => false])
            ->add('name', TextType::class)
            ->add('region', EntityType::class, ['class' => Region::class, 'choice_label' => 'name']);
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => City::class, 'csrf_protection' => false]);
    }
}
