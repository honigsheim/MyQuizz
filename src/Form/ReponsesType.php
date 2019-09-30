<?php

namespace App\Form;

use App\Entity\Reponses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ReponsesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reponse')
            ->add('reponse2')
            ->add('reponse3')
            ->add('reponse_expected')
            ->add('reponse_expected2',CheckboxType::class,[
              'mapped' => false,
                'required' => false,
            ])
            ->add('reponse_expected3',CheckboxType::class,[
               
            'mapped' => false,
            'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reponses::class,
        ]);
    }
}
