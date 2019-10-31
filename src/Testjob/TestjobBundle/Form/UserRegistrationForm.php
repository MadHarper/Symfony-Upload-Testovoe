<?php

namespace Testjob\TestjobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Testjob\TestjobBundle\Entity\User;

class UserRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextareaType::class, [
                'label' =>  ' ',
                'attr' => ['class'=>'form-control', 'rows' => '1', 'placeholder' => 'Имя...', 'label' => '']
            ])
            ->add('email', EmailType::class, [
                'label' =>  ' ',
                'attr' => ['class'=>'form-control', 'placeholder' => 'Имейл...']
            ])

            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Введенные пароли не совпадают',
                'options' => array('label' =>  ' ', 'attr' => array('class' => 'form-control', 'placeholder' => 'Пароль...')),
                'required' => true,
                'first_options'  => array('label' => ' ', 'attr' => array('class' => 'form-control', 'placeholder' => 'Пароль...')),
                'second_options' => array('label' => ' ', 'attr' => array('class' => 'form-control', 'placeholder' => 'Повторите пароль...')),

            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}