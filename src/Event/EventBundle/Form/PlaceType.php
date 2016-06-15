<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlaceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adress1','text',array(
                'attr' => array(
                'label' => ' ',
                'placeholder' => 'Adresse 1'
            )))
            ->add('adress2','text',array(
                'attr' => array(
                'label' => ' ',
                'placeholder' => 'Adresse 2'
            )))
            ->add('city','text',array(
                'attr' => array(
                'label' => ' ',
                'placeholder' => 'Ville*'
                ),
                'required' => true
            ))
            ->add('cp','number',array(
                'attr' => array(
                'label' => ' ',
                'placeholder' => 'Code Postal'
            )))
            ->add('country','text',array(
                'attr' => array(
                'label' => ' ',
                'placeholder' => 'Pays'
            )))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Place'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'event_eventbundle_place';
    }
}
