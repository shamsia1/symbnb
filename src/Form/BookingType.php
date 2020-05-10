<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, $this->getConfiguration(
                "Date d'arriver", "La date a laquelle vous comptez d'arriver", ["widget" =>"single_text"]
            ))

            ->add('endDate', DateType::class, $this->getConfiguration("Date de depart", "La date a laquelle vous quittez les lieux", ["widget" =>"single_text"]))
            
            ->add('comment', TextareaType::class, $this->getConfiguration(
            false, "si vous avez un commentaire, n'hésitez pas", ["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
