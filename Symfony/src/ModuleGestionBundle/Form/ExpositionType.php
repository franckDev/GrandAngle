<?php

namespace ModuleGestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpositionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomExposition')
            ->add('dateHeureDebutExposition', DateTimeType::class , array(
                                                'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy HH:mm',
                                                'attr' => array('class' => 'calendar'),
                                                ))
            ->add('dateHeureFinExposition', DateTimeType::class , array(
                                                'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy HH:mm',
                                                'attr' => array('class' => 'calendar'),
                                                ))
            ->add('fichier', FileType::class, array('label' => 'Image',
                                                    'data_class' => null,
                                                    'attr' => array('data-preview-file-type' => 'text',
                                                                    'id' => 'input-id')
                                                    ))
            ->add('textexpositions', CollectionType::class, array(
                                                'entry_type'   => TextExpositionType::class,
                                                'allow_add'    => true,
                                                'allow_delete' => true,
                                                'prototype'    => true,
                                                'label'        => false,
                                                'by_reference' => false
                                                ))
            ->add('evenement', ChoiceType::class, array(
                                                'choices'  => array(
                                                    'Teaser&Affiche' => 'teaser',
                                                    'Déploiement' => 'deploie',
                                                    'Inauguration' => 'inaugurer',
                                                    'Fermeture' => 'fermer'
                                                    ),
                                                'expanded' => true,
                                                'multiple' => false,
                                                'required' => true
                                                ))
            ->add('organisateur', EntityType::class, array(
                                                'class' => 'ModuleGestionBundle:organisateur',
                                                'choice_label' => 'nom'
                                                ))
            ->add('themes', EntityType::class, array(
                                                'class' => 'ModuleGestionBundle:Theme',
                                                'choice_label' => 'libelle',
                                                'expanded' => false,
                                                'required'    => true,
                                                'multiple' => true
                                                ))
            ->add('emplacements', CollectionType::class, array(
                                                'entry_type'   => EmplacementType::class,
                                                'allow_add'    => true,
                                                'allow_delete' => true,
                                                'prototype'    => true,
                                                'label'        => false,
                                                'by_reference' => false
                                                ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuleGestionBundle\Entity\Exposition'
        ));
    }
}
