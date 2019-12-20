<?php

namespace App\Form;

use App\Entity\Ads;
use App\Entity\Categories;
use App\Enum\AdsStateEnum;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            /* Ad Title */        
            ->add('title', TextType::class, [
                'label' => "Ad title",
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
            
            /* Ad Price */            
            ->add('price', NumberType::class, [
                'label' => "Ad price",
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
            
            /* Ad Description */            
            ->add('description', TextareaType::class, [
                'label' => "Ad description",
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
            
            /* Ad State */            
            ->add('state', ChoiceType::class, [
                'label' => "Object state",
                'help' => "xxx",

                'choices' => array_flip(AdsStateEnum::getAvailableStates()),
                
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
            
            /* Ad Category */            
            ->add('category', EntityType::class, [
                'label' => "Category",
                // 'help' => "xxx",
                'class' => Categories::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('t1')
                        ->orderBy('t1.name', 'ASC')
                    ;
                },
                // 'choice_label' => 'name',
                'choice_label' => function($myCategList){
                    $label = $myCategList->getName()." ";
                    $label.= $myCategList->getColor();

                    return $label;
                },
                
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
            
            /* Ad Address */            
            ->add('location', AddressType::class, [
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ads::class,
        ]);
    }
}
