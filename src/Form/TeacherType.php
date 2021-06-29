<?php

namespace App\Form;

use App\Entity\Teacher;
use App\Repository\SubjectRepository;
use App\Repository\ClassSchoolRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    private $subjectRepo;
    private $classRepo;

    public function __construct(SubjectRepository $subjectRepo, ClassSchoolRepository $classRepo)
    {
        $this->subjectRepo = $subjectRepo;
        $this->classRepo = $classRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', null, ['required' => false])
            ->add('phone_number', TextType::class, ['attr' => ['minlength' => 9, 'maxlength' => 9]])
            ->add('isAdmin', CheckboxType::class, ['mapped' => false, 'required' => false])
            ->add('subject', CollectionType::class, [
                'label' => 'Subjects',
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'choices' => $this->getAllSubjectName(),
                ],
            ])
            ->add('aclass', ChoiceType::class, [
                /* 'mapped' => false, */
                'required' => false,
                'label' => 'Class',
                'choices' => $this->getAllClassName(),
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['minlength' => 6, 'maxlength' => 250]],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat'],
                'error_bubbling' => true,
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }

    private function getAllSubjectName(): array
    {
        $subjects = $this->subjectRepo->findBy([], ['name' => 'asc']);
        $nameArr = ['----' => null,];
        foreach ($subjects as $sub) {
            $nameArr[$sub->getName()] = $sub->getName();
        }

        return $nameArr;
    }

    private function getAllClassName(): array
    {
        $classes = $this->classRepo->findAll([]);
        $names = [];
        foreach ($classes as $class) {
            $names[$class->getName()] = $class;
        }

        return $names;
    }
}
