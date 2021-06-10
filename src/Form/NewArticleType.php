<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Category;

class NewArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class)
            ->add('description',TextType::class)
            ->add('content',hiddenType::class)
            ->add('pathTitle',TextType::class)
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'dev' => '1'
                ]
            ])
            ->add('headerImage',hiddenType::class)
            ->add('thumbnail',hiddenType::class)
            ->add('save',SubmitType::class)
        ;
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Article::class,
    //     ]);
    // }
}
