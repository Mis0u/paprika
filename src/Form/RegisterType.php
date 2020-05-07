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

class RegisterType extends AbstractType
{
    const BOSS_NAME = "misiti";
    const BOSS_FIRSTNAME = "mickael";
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $builder
            ->add('lastName', TextType::class, [
                'label' => false, 
                'required' => true,
                'attr' => ['placeholder' => 'Indiquer son nom...']
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => ['placeholder' => 'Son prénom...']
            ])
            ->add('isMale', CheckboxType::class, [
                'label' => 'L\'employé est-il un homme ?',
                'required' => false,
            ])
            ->add('isLeader', CheckboxType::class, [
                'label' => 'L\'employé est-il leader ?',
                'required' => false,
            ])
            ->add('workTeam', EntityType::class, [
                'class' => Team::class,
                'label' => false,
                'required' => true,
                'placeholder' => false,
                'query_builder' => function(TeamRepository $teamRepo){
                    return $teamRepo->findLeaderExceptBossLastName(self::BOSS_NAME);
                },
                'query_builder' => function(TeamRepository $teamRepo){
                    return $teamRepo->findLeaderExceptBossFirstName(self::BOSS_FIRSTNAME);
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
