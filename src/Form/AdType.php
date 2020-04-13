<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\ApplicationType;


class AdType extends ApplicationType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Tapez un super titre pour votre annouce"))

            ->add('slug', TextType::class, $this->getConfiguration("Address web", "Tapez l'address web (automatique)", [
                    'required' => false
            ]))

            ->add('coverImage', UrlType::class, $this->getConfiguration("Url de l'image pricipale", "Donnez l'address d'une image qui donne vraiment envie"))

            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Donnez une discription global de l'announce"))

            ->add('content', TextareaType::class, $this->getConfiguration("Description détaillée", "Tapez une discription qui donne vraiment envie de venir chez vous"))   

            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambre", "Nombre de chambre disponible"))

            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Indiquez le prix que vous voulez par nuit"))

            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,
                'allow_delete' => true
            ])   
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
