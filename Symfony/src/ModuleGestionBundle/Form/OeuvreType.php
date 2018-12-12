<?php

namespace ModuleGestionBundle\Form;

use ModuleGestionBundle\Entity\Emplacement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('genFlashcode')
            ->add('artiste', EntityType::class, array(
                'class' => 'ModuleGestionBundle:Artiste',
                'label' => false,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('a')
                              ->orderBy('a.nom', 'ASC');
                },
                'choice_label' => 'nomcomplet',))
            ->add('texteoeuvres', CollectionType::class, array(
                'entry_type'    => TexteOeuvreType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'label'         => false,
                'prototype'     => true,
                'by_reference'  => false))
            ->add('multimedias', CollectionType::class, array(
                'entry_type' => MultimediaType::class,
                'allow_add'     => true,
                'allow_delete' => true,
                'label'      => false,
                'prototype'  => true,
                'by_reference' => false))
            ->add('tableau', CollectionType::class, array(
                'entry_type' => TableauType::class,
                'allow_add'  => true,
                'allow_delete' => true,
                'label' => false,
                'prototype' => true,
                'by_reference' => false))
            ->add('multi', CollectionType::class, array(
                'entry_type' => MultimediaTypeType::class,
                'allow_add'  => true,
                'allow_delete' => true,
                'label' => false,
                'prototype' => true,
                'by_reference' => false))
            ->add('statut', CollectionType::class, array(
                'entry_type' => StatutType::class,
                'allow_add'  => true,
                'allow_delete' => true,
                'label' => false,
                'prototype' => true,
                'by_reference' => false))
            ->add('image', FileType::class, array('label' => 'Image',
                                                    'data_class' => null))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuleGestionBundle\Entity\Oeuvre'
        ));
    }
}
