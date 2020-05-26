<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
            ->add('rating', IntegerType::class, $this->getConfiguration("Note sur ",
            "Veuillez indiquer votre note de 0 a 5", [
                'attr' =>[
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ]) )
            ->add('content', TextareaType::class, $this->getConfiguration("votre avis / temoinage",
            "n'hesitez pas a etre trés précis, cela aidera nos futurs voyageurs"))
           
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
