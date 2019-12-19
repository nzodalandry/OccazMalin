<?php

namespace App\Form;

use App\Entity\Addresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            /* Primary address field */
            ->add('address', TextType::class, [
                'label' => "xxx",
                'help' => "xxx",
                
                'required' => true,

                'attr' => [
                    'class' => "form-control",
                ],
                'help_attr' => [
                    'class' => "text-muted",
                ],

                'constraints' => [

                ],
            ])
            
            /* Secondary address field */
            ->add('additional', TextType::class, [
                'label' => "xxx",
                'help' => "xxx",
                
                'required' => true,

                'attr' => [
                    'class' => "form-control",
                ],
                'help_attr' => [
                    'class' => "text-muted",
                ],

                'constraints' => [

                ],
            ])
            
            /* Postal code */
            ->add('postalcode', TextType::class, [
                'label' => "xxx",
                'help' => "xxx",
                
                'required' => true,

                'attr' => [
                    'class' => "form-control",
                ],
                'help_attr' => [
                    'class' => "text-muted",
                ],

                'constraints' => [

                ],
            ])
            
            /* City */
            ->add('city', TextType::class, [
                'label' => "xxx",
                'help' => "xxx",
                
                'required' => true,

                'attr' => [
                    'class' => "form-control",
                ],
                'help_attr' => [
                    'class' => "text-muted",
                ],

                'constraints' => [

                ],
            ])
            
            /* Region */
            ->add('region', TextType::class, [
                'label' => "xxx",
                'help' => "xxx",
                
                'required' => true,

                'attr' => [
                    'class' => "form-control",
                ],
                'help_attr' => [
                    'class' => "text-muted",
                ],

                'constraints' => [

                ],
            ])
            
            /* Country */
            ->add('country', CountryType::class, [
                'label' => "xxx",
                'help' => "xxx",
                
                'required' => true,

                'attr' => [
                    'class' => "form-control",
                ],
                'help_attr' => [
                    'class' => "text-muted",
                ],

                'constraints' => [

                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Addresses::class,
        ]);
    }
}
