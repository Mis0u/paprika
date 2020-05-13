<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Form\Service\OptionType;
use App\Repository\TeamRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegisterType extends OptionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, $this->addFormOptions(OptionType::NO_LABEL, OptionType::REQUIRED,['placeholder' => 'Indiquer son nom...']))
            ->add('firstName', TextType::class, $this->addFormOptions(OptionType::NO_LABEL, OptionType::REQUIRED,['placeholder' => 'Son prénom...']))
            ->add('isMale', CheckboxType::class, $this->addFormOptions('L\'employé est-il un homme ?', false))
            ->add('isLeader', CheckboxType::class, $this->addFormOptions('L\'employé est-il leader ?', OptionType::NOT_REQUIRED,['class' => 'isLeader']))
            ->add('workTeam', EntityType::class, [
                'class' => Team::class,
                'attr'=> ['class' => 'workTeam'],
                'label' => 'L\'assigner à un chef d\'équipe :',
                'required' => true,
                'placeholder' => false,
                'query_builder' => function(TeamRepository $teamRepo){
                    return $teamRepo->findLeaderExceptBoss(OptionType::NOT_BOSS);
                },
                'choice_label' => function($leader){
                    return ucwords($leader->fullLeaderName());
                },
                'expanded' => false,
                'multiple' => false
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
