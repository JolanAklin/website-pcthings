<?php

namespace App\Form;

use App\Entity\BlogPost;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Validator\Constraints\NotBlank;

class NewBlogPostType extends AbstractType
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
            ->add('content', HiddenType::class, [
                'attr' => ['class' => 'fillWithJSON input'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'The article needs content',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }
}
