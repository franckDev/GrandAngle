<?php

namespace ModuleGestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultimediaTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('duree')
            ->add('stockage')
            ->add('video')
            ->add('fichier', FileType::class, array('label' => 'Multimédia (Image, Vidéo ou Son)',
                                                    'data_class' => null))
            ->add('multi', TypeOeuvreType::class, array(
                'data_class' => 'ModuleGestionBundle\Entity\TypeOeuvre',
                'label'         => false,
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuleGestionBundle\Entity\MultimediaType'
        ));
    }
}
