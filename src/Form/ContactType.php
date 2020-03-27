<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\CategoryQuestions;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'

            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu', 
                'attr' => [
                    'placeholder' => 'Ta source de mécontentement ! Attention sois gentil, ou je te tape ! '
                ]
            ])
            ->add('reason', EntityType::class, [
                'label'=>'Raison du message', 
                'required'=>false,
                'class' => CategoryQuestions::class
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'crsf_protection' =>false
        ]);
    }

    public function getBlockPrefix()
    {
        return ''; 
    }

}
