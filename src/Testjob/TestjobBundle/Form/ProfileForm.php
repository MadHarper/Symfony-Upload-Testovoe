<?php

namespace Testjob\TestjobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Testjob\TestjobBundle\Entity\User;

class ProfileForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio', TextareaType::class, [
                'label' =>  ' ',
                'attr' => ['class'=>'form-control', 'rows' => '1', 'placeholder' => 'Имя...', 'label' => '']
            ])
            ->add('birthday', BirthdayType::class, [
                'label' =>  ' ',
                'attr' => ['class'=>'form-control', 'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                ]]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);

    }
}