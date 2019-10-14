<?php

namespace App\Form;

use App\Entity\Serie;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('duree')
            ->add('premiereDiffusion')
            ->add('image')
            //->add('lesGenres')
            ->add('lesGenres', EntityType::class, array('class'=>Genre::class, 'choice_label'=>'libelle', 'multiple'=>true, 'expanded'=>true, 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('genre')
                    ->orderBy('genre.libelle', 'ASC');
            }))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
