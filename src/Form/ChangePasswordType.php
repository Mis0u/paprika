<?php

namespace App\Form;


use App\Entity\ChangePassword;
use App\Form\Service\OptionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends OptionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->addFormOptions(false, OptionType::REQUIRED,['placeholder' =>'Indiquez votre ancien mot de passe']))
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identique',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' =>['placeholder' => 'Indiquez votre nouveau mot de passe']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Répétez le nouveau mot de passe']],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChangePassword::class,
        ]);
    }
}