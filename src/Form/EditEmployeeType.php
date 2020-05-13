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

class EditEmployeeType extends OptionType
{
    const NOT_BOSS = 0;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, $this->addFormOptions('Nom de famille', OptionType::REQUIRED))
            ->add('firstName',TextType::class, $this->addFormOptions('Prénom', OptionType::REQUIRED))
            ->add('isMale',CheckboxType::class, $this->addFormOptions('Est-ce un homme ?', OptionType::NOT_REQUIRED))
            ->add('isLeader', CheckboxType::class, $this->addFormOptions(OptionType::NO_LABEL, OptionType::NOT_REQUIRED))
            ->add('workTeam', EntityType::class, [
                'class' => Team::class,
                'required' => true,
                'placeholder' => false,
                'query_builder' => function(TeamRepository $teamRepo){
                    return $teamRepo->findLeaderExceptBoss(self::NOT_BOSS);
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
