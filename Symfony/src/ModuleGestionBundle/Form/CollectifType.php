<?php

namespace ModuleGestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectifType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('organisateur', OrganisateurType::class, array(
                                                'data_class' => 'ModuleGestionBundle\Entity\Organisateur',
                                                'label'   =>  false
                                                ))
            ->add('datecreation', DateTimeType::class , array(
                                                'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd-MM-yyyy HH:mm',
                                                'attr' => array('class' => 'calendar'),
                                                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ModuleGestionBundle\Entity\Collectif'
        ));
    }
}
