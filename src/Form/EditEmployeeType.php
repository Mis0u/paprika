<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class,[
                'label' => 'Nom de famille'
            ])
            ->add('firstName',TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('isLeader',CheckboxType::class,[
                'label' => 'Est-il leader ?',
                'required' => false
            ])
            ->add('isMale',CheckboxType::class,[
                'label' => 'Est-ce un homme ?',
                'required' => false
            ])
            ->add('workTeam', EntityType::class,[
                'class' => Team::class,
                'choice_label' => 'fullLeaderName',
                'label' => 'Dans l\'équipe de :'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
