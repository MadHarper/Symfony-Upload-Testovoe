<?php

namespace Testjob\TestjobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ImageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, ['label' => 'Изображение'])
            ->add('comment', TextareaType::class, [
                'label' =>  'Комментарий',
                'attr' => ['class'=>'form-control', 'rows' => '3', 'placeholder' => 'Комментарий', 'label' => '']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Testjob\TestjobBundle\Entity\Image',
        ));
    }
}