<?php

namespace ModuleGestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('locked', CheckboxType::class, array('required' => false))
            ->add('telephones', CollectionType::class, array(
                'entry_type'    => TelephoneType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'label'         => false,
                'prototype'     => true,
                'by_reference'  => false))
            ->add('role', ChoiceType::class, array(
                  'choices' => array(
                      'Utilisateur' => 'USER',
                      'Administrateur' => 'ADMIN',
                      ),
                ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuleGestionBundle\Entity\Utilisateur'
        ));
    }

     public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
}
