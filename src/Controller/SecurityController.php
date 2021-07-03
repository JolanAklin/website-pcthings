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

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\EditUserType as FormEditUserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
         $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', 
        ['last_username' => $lastUsername, 
        'error' => $error,
        ]);
    }

    public function editUserSelf(Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $error = null;
        $user = $this->getUser();
        $form = $this->get('form.factory')->createNamed('editUserForm', FormEditUserType::class, $user);
        try {
            $errors = [];
            $form->handleRequest($request);
            //update the user's infos
            if ($form->isSubmitted() && $form->isValid()) {
    
                $user = $form->getData();
                
                //update the password
                $pass = $form->get('password')->getData();
                if($pass !== null && $pass != "")
                {
                    $user->setPassword($this->passwordHasher->hashPassword(
                        $user,
                        $pass
                    ));
                }
                

                //move the uploaded profile picture
                if($form->get('profilPic')->getData() !== null)
                {
                    $userProfilPic = $form->get('profilPic')->getData();
                    $userProfilPic->move($this->getParameter('profil_pic_dir'), $user->getProfilPic());
                }

                //validate if the user object is valide for doctrine
                $validator_errors = $validator->validate($user);
                if(count($validator_errors)!=0)
                {
                    throw new \LogicException('User couldn\'t be validated');   
                }

                //persist the user entity
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                //return page if everything is ok
                $this->addFlash('success', 'Your account has been successfully updates');
                return $this->redirectToRoute('edit_user', $request->query->all());
            }
            if($form->isSubmitted())
            {
                //get all the error of the form
                foreach ($form as $child) {
                    foreach ($child->getErrors() as $error) {
                        array_push($errors, $error->getMessage());
                    }
                }
            }

        } catch (\Throwable $th) {
            $error = "Something bad happened, try again";
            array_push($errors, $error);
        }

        //return page in case of errors
        return $this->render('security/edit_user.html.twig', 
        ['errors' => $errors,
        'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
