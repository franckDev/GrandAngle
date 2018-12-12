<?php

namespace ModuleGestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('hauteur')
            ->add('longueur')
            ->add('largeur')
            ->add('profondeur')
            ->add('statut', TypeOeuvreType::class, array(
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
            'data_class' => 'ModuleGestionBundle\Entity\Statut'
        ));
    }
}
