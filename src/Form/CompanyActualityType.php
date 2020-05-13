<?php

namespace App\Form;

use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use App\Entity\CompanyActuality;
use App\Form\Service\OptionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyActualityType extends OptionType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('news', FroalaEditorType::class, $this->addFormOptions(OptionType::NO_LABEL, OptionType::NOT_REQUIRED));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanyActuality::class,
        ]);
    }
}
