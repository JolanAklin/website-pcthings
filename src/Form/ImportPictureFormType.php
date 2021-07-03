<?php
/*
Copyright 2021 Jolan Aklin and Yohan Zbinden

This website is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, version 3 of the License.

This website is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this software.  If not, see <https://www.gnu.org/licenses/>.
*/

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
