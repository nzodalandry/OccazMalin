<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /* Firstname */
            ->add('firstname', TextType::class, [
                'label' => "Firstname",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Firstname",
                ],
            ])

            /* Lastname */
            ->add('lastname', TextType::class, [
                'label' => "Lastname",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Lastname",
                ],
            ])

            /* Birthday */
            ->add('birthday', BirthdayType::class, [
                'label' => "Birthday",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Birthday",
                ],
                'years' => $this->getYears(),
            ])

            /* Email */
            ->add('email', EmailType::class,[
                'label' => "Email",
                'attr' => [
                    'class' => "form-control",
                    'placeholder' => "Email",
                ],
            ])

            /* Password */
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => false,
                'first_options'  => [
                    'label' => "Nouveau mot de passe",
                    'required' => true,
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "Nouveau mot de passe",
                    ],
                    'constraints' => [
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password should be at least {{ limit }} characters',
                            'max' => 32,
                        ]),
                        new NotBlank([
                            'message' => "Saisir votre nouveau mot de passe",
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => "Repéter le mot de passe",
                    'attr' => [
                        'class' => "form-control",
                        'placeholder' => "Repéter le mot de passe",
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => "Repéter le mot de passe",
                        ]),
                    ],
                ],
                'invalid_message' => "Les mots de passe doivent etre identiques.",
                // // instead of being set onto the object directly,
                // // this is read and encoded in the controller
                // 'mapped' => false,
                // 'constraints' => [
                //     new NotBlank([
                //         'message' => 'Please enter a password',
                //     ]),
                //     new Length([
                //         'min' => 6,
                //         'minMessage' => 'Your password should be at least {{ limit }} characters',
                //         // max length allowed by Symfony for security reasons
                //         'max' => 4096,
                //     ]),
                // ],
            ])

            /* Terms */
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "I agree terms of use.",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

    private function getYears()
    {
        $years = [];
        $now = date('Y');
        $now18 = $now-12;
        $range = 100;

        for ($i=$now18; $i>($now18-$range); $i--)
        {
            $years[] = $i;
        }

        return $years;
    }
}
