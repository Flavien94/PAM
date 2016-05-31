<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('sector', 'entity', array('class' => 'Event\EventBundle\Entity\Sector',
        'property' => 'caption',
        'multiple' => false,
        'empty_value' => 'Secteurs',
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
            'data_class' => 'Event\EventBundle\Entity\Sector'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'event_eventbundle_sector';
    }
}
