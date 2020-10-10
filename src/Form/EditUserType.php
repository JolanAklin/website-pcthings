<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'Your username mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false, 
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 8,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                        'match' => true,
                        'message' => 'Your password must contain at least one uppercase letter, one lowercase letter, one number and one special character (@, $, !, %, *, ?, &)',
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'Your username mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'Your username mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('email', TextType::class, [
                'constraints' => [
                    new Email([
                        'message' => 'The email "{{ value }}" is not a valid email.',
                    ])
                ]
            ])
            ->add('profilPic', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxHeight' => '512',
                        'maxWidth' => '512'
                    ])
                ]
            ])
            //->add('blogImage')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
