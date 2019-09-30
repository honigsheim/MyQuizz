<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Categorie;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('categorie',EntityType::class, [
                        'class' => Categorie::class,
                        'choice_label' => 'name'
                    
                    ])
            ->add('image')
            // ->add('question')
            // ->add('reponse')
            
            // ->add('reponse_expected')
            // ->add('reponse')
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
