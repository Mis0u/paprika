<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeamRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EditEmployeeType extends AbstractType
{
    const NOT_BOSS = 0;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class,[
                'label' => 'Nom de famille'
            ])
            ->add('firstName',TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('isLeader', CheckboxType::class, [
                'label' => 'L\'employé est-il leader ?',
                'attr'=> ['class' => 'isLeader'],
                'required' => false,
            ])
            ->add('isMale',CheckboxType::class,[
                'label' => 'Est-ce un homme ?',
                'required' => false
            ])
            ->add('workTeam', EntityType::class, [
                'class' => Team::class,
                'attr'=> ['class' => 'workTeam'],
                'label' => false,
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
