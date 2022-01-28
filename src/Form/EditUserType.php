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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('displayedNickName', TextType::class, [
                'attr'=> ['class'=>'input'],
            ])
            ->add('password', PasswordType::class, [
                'attr'=> ['class'=>'input'],
                'mapped' => false, 
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Your password must be at least {{ limit }} characters long'
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/',
                        'match' => true,
                        'message' => 'Your password must contain at least one uppercase letter, one lowercase letter, one number and one special character (@, $, !, %, *, ?, &)',
                    ]),
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'Your password mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'attr'=> ['class'=>'input'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'Your first name mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr'=> ['class'=>'input'],
                'constraints' => [
                    new Regex([
                        'pattern' => '/\s/',
                        'match' => false,
                        'message' => 'Your lastname mustn\'t contain a white space',
                    ])
                ]
            ])
            ->add('email', TextType::class, [
                'attr'=> ['class'=>'input'],
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
                        'maxWidth' => '512',
                        'allowPortrait' => 'false',
                        'allowLandscape' => 'false'
                    ])
                ]
            ])
            //->add('blogImage')
            ->add('save', SubmitType::class, ['attr'=> ['class'=>'all-width'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
