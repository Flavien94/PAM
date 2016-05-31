<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type', 'entity', array('class' => 'Event\EventBundle\Entity\Type',
        'property' => 'title',
        'multiple' => false,
        'empty_value' => 'Type d\'évenement',
        'required' => false
        ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Type'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'event_eventbundle_type';
    }
}
