<?php

namespace App\Form\Service;

use Symfony\Component\Form\AbstractType;

class OptionType extends AbstractType
{
    const NO_LABEL = false;
    const NOT_REQUIRED = false;
    const REQUIRED = true;
    const NOT_BOSS = 0;

    public function addFormOptions($label, bool $required, array $attr = []): array
    {
        return [
            'label' => $label,
            'required' => $required, 
            'attr' => $attr
        ];
    }
}