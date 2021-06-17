<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NewArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr'=> ['class'=>'input'],
            ])
            ->add('description', TextType::class, [
                'attr'=> ['class'=>'input'],
            ])
            ->add('content', hiddenType::class, ['attr' => ['class' => 'fillWithJSON input']])
            ->add('pathTitle', TextType::class, [
                'attr'=> ['class'=>'input'],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose the category',
                'attr'=> ['class'=>'input'],
            ])
            ->add('headerImage', hiddenType::class, ['mapped' => false])
            ->add('thumbnail', hiddenType::class, ['mapped' => false])
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
