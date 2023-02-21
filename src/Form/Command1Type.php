<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Command;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class Command1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class,array('data'=>new \DateTime()))
            ->add('price')
            ->add('quantity')
            ->add('status')
            ->add('total')
            ->add('User',
            EntityType::class,
            [
                'class' => User::class,
                'choice_label' => 'last_name',
                'placeholder' => 'Choisir un user',
                'label' => 'Catégorie',
               'label' => 'User',
            ]

            )
            ->add('product',
            EntityType::class,
            [
                'class' => Product::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un product',
                'label' => 'Product',
            ]

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Command::class,
        ]);
    }
}
