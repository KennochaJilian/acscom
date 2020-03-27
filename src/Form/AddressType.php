<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameUser', TextType::class,[
                'label' => 'Nom et prénom',
                'attr' => [
                    'placeholder' => 'Nom et prénom'
                ]
            ])
            ->add('street', TextType::class,[
                'label' => 'Rue',
                'attr' => [
                    'placeholder' => 'Rue'
                ]
            ])
            ->add('zipCode', NumberType::class, [
                'label' => 'Code postal',
                'attr' =>[
                    'placeholder' =>'Code postal'
                ]
            ])
            ->add('city', TextType::class,[
                'label' => 'Ville',
                'attr'=>[
                    'placeholder' =>'Ville'
                ]
            ])
            ->add('deliveryAdress')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
