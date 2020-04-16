<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use App\Form\ApplicationType;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class RegistrationType extends ApplicationType
{

   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, $this->getConfiguration("prénom", "Votre prénom ..."))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Votre Nom de famille"))
            ->add('email', EmailType::class, $this->getConfiguration("Email", "Votre adresse email"))
            ->add('picture', UrlType::class, $this->getConfiguration("Photo de profil", "Url de votre avatar"))
            ->add('hash', passwordType::class, $this->getConfiguration("Mot de pass", "Votre Choisissez un bon mot de pass"))
            ->add('passwordConfirm', PasswordType::class, $this->getConfiguration("Confirmation de mot de pass", "Veuillez confirmer votre mot de pass"))
            ->add('introduction', TextType::class, $this->getConfiguration("introduction", "presentez vous en quelque mots"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description détaillée", "c'est le moment de vous presenter en détails"))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
