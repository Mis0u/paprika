<?php

namespace App\Form;

use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use App\Entity\Mission;
use App\Form\Service\OptionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends OptionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content',FroalaEditorType::class, $this->addFormOptions(OptionType::NO_LABEL, OptionType::NOT_REQUIRED));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
