<?php

namespace App\Controller;

use App\Form\EditUserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\Persistence\ManagerRegistry;

class LoginController extends AbstractController
{
    public function index(AuthenticationUtils $authenticationUtils): Response
    {

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    public function editUserSelf(ManagerRegistry $doctrine, Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $error = null;
        $user = $this->getUser();
        $form = $this->createForm(EditUserType::class, $user);
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
                $entityManager = $doctrine->getManager();
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
}
