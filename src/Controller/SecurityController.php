<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\BlogPost;
use App\Entity\Article;
use App\Entity\Image;
use App\Entity\EditUserType;
use App\Form\EditUserType as FormEditUserType;
use Error;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
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
        'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
        'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
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
                    $user->setPassword($this->passwordEncoder->encodePassword(
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
        'blogs_latest' => $this->getDoctrine()->getRepository(BlogPost::class)->findBlogByDate(),
        'articles_latest' => $this->getDoctrine()->getRepository(Article::class)->findArticleByDate(),
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
