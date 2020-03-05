<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\CategoryQuestions;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('content')
            ->add('reason', EntityType::class, [
                'label'=>false, 
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
