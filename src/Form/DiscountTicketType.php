<?php

namespace App\Form;

use App\Entity\DiscountTicket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscountTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeContent', TextType::class,  [
                'label' => false,
                'attr' => [
                    'placeholder' => "Code promo ou points de fidelité"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DiscountTicket::class,
        ]);
    }
}
