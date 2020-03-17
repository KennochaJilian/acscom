<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\DeliveryOptions;
use App\Entity\Order;
use App\Repository\AdressRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Security;

class OrdersType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security; 

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('optionGift')
            ->add('deliveryOption', EntityType::class, [
                'class' => DeliveryOptions::class,
                'choice_label' => 'name' ,
                'choice_value' => 'name', 
                'expanded' => false, 
                'multiple'=> false,
            ])
            ->add('deliveryAddress', EntityType::class, [
                'class' => Adress::class,
                'query_builder' => function(AdressRepository $repo){
                    return $repo->getAdressUser($this->security->getUser()); 
                },
                'choice_label' => 'nameUser' ,
                'choice_value' => 'id', 
                'expanded' => false, 
                'multiple'=> false,
            ])
            ->add('facturationAddress',  EntityType::class, [
                'class' => Adress::class,
                'query_builder' => function(AdressRepository $repo){
                    return $repo->getAdressUser($this->security->getUser()); 
                },
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
