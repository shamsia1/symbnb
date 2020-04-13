<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\RegistrationType;




class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
    	$error = $utils->getLastAuthenticationError();
    	$username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [

        	 'hasError' => $error !== null, 
        	 'username' => $username
        ]);
    }

    /**
    * @Route("/logout", name="account_logout")
    * @return void
    *
    */
    public function logout()
    {

    }

    /**
    * permet d'afficher le formulaire d'inscription
    * @Route("/register", name="account_register")
    * @return Response
    *
    */
    public function register()
    {
    	$user = new user();

    	$form = $this->createForm(RegistrationType::class, $user);

    	return $this->render('account/registration.html.twig',[
    		'form' => $form->createView()
    	]);


    }
}
