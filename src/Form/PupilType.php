<?php

namespace App\Form;

use App\Entity\ClassSchool;
use App\Entity\Pupil;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PupilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['attr' => ['minlength' => 4]])
            ->add('phone_to_parents', null, ['attr' => ['minlength' => 9, 'maxlength' => 9]])
            ->add('sex', ChoiceType::class, [
                'choices' => ['male' => 'm', 'female' => 'f']
            ])
            ->add('class', EntityType::class, ['class' => ClassSchool::class, 'choice_label' => 'name'])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pupil::class,
        ]);
    }
}
