<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\Image as ImageConstraint;
use Symfony\Component\Validator\Constraints\Regex;

class ImportPictureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr'=> ['class'=>'input'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/\/|'.addslashes("\\").'/',
                        'match' => false,
                        'message' => 'Your image title mustn\'t contain a "/" nor a "\"',
                    ])
                ]
            ])
            ->add('alt', TextType::class, [
                'attr'=> ['class'=>'input'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/\/|'.addslashes("\\").'/',
                        'match' => false,
                        'message' => 'Your image alt mustn\'t contain a "/" nor a "\"',
                    ])
                ]
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new ImageConstraint([
                        'maxHeight' => '2000',
                        'maxWidth' => '2000',
                    ])
                ]
            ])
            ->add('save', SubmitType::class, ['attr'=> ['class'=>'all-width'],])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
