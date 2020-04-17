<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;






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
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
    	$user = new user();

    	$form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);


           $manager = $this->getDoctrine()->getManager();

           $manager->persist($user);

            $manager->flush(); 

            $this->addFlash('success', "Votre compte a bien été créé! Vous pouvez vous connecter !");
            return $this->redirectToRoute(('account_login'));
        }


    	return $this->render('account/registration.html.twig',[
    		'form' => $form->createView()
    	]);


    }

    /**
     * permet d'afficher et de traiter le formulaire de modification de profile
     * 
     * @Route("/account/profile", name="account_profile")
     * 
     * @return Response
     */
    public function profile(Request $request){
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', "les données de profile ont été enregistrer avec succés !");
        }
        return $this->render("account/profile.html.twig",[
            'form' => $form->createView()
        ]);

    }


    /**
     * permet de modifier le mot de pass
     * 
     * @Route("/account/password-update", name="account_password")
     * @return Response
     */
    public function updatePassword(){
        $passwordupdate = new PasswordUpdate();

        $form = $this->createForm(PasswordUpdateType::class, $passwordupdate);

        return $this->render("account/password.html.twig",[
            'form' => $form->createView()
        ]);

    }
}

