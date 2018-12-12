<?php

namespace ModuleGestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('imgFlashcode')
            ->add('etat', ChoiceType::class, array(
                'choices' => array(
                    'Pas livré' => 'Pas livré',
                    'Livré'     => 'Livré',
                    'En cours'  => 'En cours',
                ),
                'multiple' => false,
                'expanded' => true))
            ->add('nombreVisite')
            ->add('emplacement', EmplacementType::class)
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
