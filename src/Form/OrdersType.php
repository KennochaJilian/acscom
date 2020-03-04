<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\DeliveryOptions;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('optionGift')
            ->add('deliveryOption', EntityType::class, [
                'class' => DeliveryOptions::class,
                'choice_label' => 'name' ,
                'choice_value' => 'id', 
                'expanded' => false, 
                'multiple'=> false,
            ])
            ->add('deliveryAddress', EntityType::class, [
                'class' => Adress::class,
                'choice_label' => 'nameUser' ,
                'choice_value' => 'id', 
                'expanded' => false, 
                'multiple'=> false,
            ])
            ->add('facturationAddress',  EntityType::class, [
                'class' => Adress::class,
                'choice_label' => 'nameUser' ,
                'choice_value' => 'id', 
                'expanded' => false, 
                'multiple'=> false,
            ])
            ->add('Acheter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
