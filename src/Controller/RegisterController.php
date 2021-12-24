<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="register")
     */
    public function index(HttpFoundationRequest $request , UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm( RegisterFormType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            try{
                $user = $form->getData();
                $password = $encoder->hashPassword($user,$user->getPassword());
                $user->setPassword($password);

                $user->setRoles(['ROLE_USER']);
                
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $this->redirectToRoute('home');
                
            }
            catch(Exception $e) {
                return $this->render('register/index.html.twig', 
                ['form'=>$form->createView(),
                    "Erreur"=>$e]);
            }
         
        }
        return $this->render('register/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
