<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class NewArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr'=> ['class'=>'input'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs a title',
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr'=> ['class'=>'input'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs a description',
                    ]),
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'The description needs to be less than 50 characters',
                    ]
                    )
                ]
            ])
            ->add('content', HiddenType::class, [
                'attr' => ['class' => 'fillWithJSON input'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs content',
                    ])
                ]
            ])
            ->add('pathTitle', TextType::class, [
                'attr'=> ['class'=>'input'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs a path',
                    ]),
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'The article path mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose the category',
                'attr'=> ['class'=>'input'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs a category',
                    ])
                ]
            ])
            ->add('headerImage', EntityType::class, [
                'class' => Image::class,
                'placeholder' => 'Choose the header image',
                'mapped' => true,
                'required' => true,
                'choice_label' => function ($image) {
                    $return = $image->getTitle();
                    return $return;
                },
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs a category',
                    ])
                ]
            ])
            ->add('thumbnail', EntityType::class, [
                'class' => Image::class,
                'placeholder' => 'Choose the thumbnail image',
                'mapped' => true,
                'required' => true,
                'choice_label' => function ($image) {
                    $return = $image->getTitle();
                    return $return;
                },
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs a category',
                    ])
                ]
            ])
            //->add('save', SubmitType::class, ['attr' => ['class' => 'validateForm']])
        ;
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Article::class,
    //     ]);
    // }
}
