<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateIn')
            ->add('dateOut')
            ->add('price')
            ->add('nbPerson')
            ->add('User', 
            EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'first_name',
                    'placeholder' => 'Choisir un user',
                    'label' => 'user',
                ]
            )
            ->add('Product',
            EntityType::class,
                [
                    'class' => Product::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Choisir un product',
                    'label' => 'product',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
