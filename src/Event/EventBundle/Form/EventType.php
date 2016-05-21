<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author')
            ->add('title')
            ->add('description')
            ->add('place')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('contact_name')
            ->add('contact_email')
            ->add('publics', 'collection', array(
            'type'         => new PublicsType(),
            'allow_add'    => true,
            'allow_delete' => true
            ))
            ->add('publics', 'entity', array(
                  'class'    => 'EventBundle:Publics',
                  'property' => 'title',
                  'multiple' => false,
                  'empty_value' => 'Public'
                  ))
            ->add('type', 'collection', array(
                  'type'         => new TypeType(),
                  'allow_add'    => true,
                  'allow_delete' => true
                  ))
            ->add('type', 'entity', array(
                   'class'    => 'EventBundle:Type',
                   'property' => 'title',
                   'multiple' => false,
                   'empty_value' => 'Type d\'évenement'
                  ))
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'event_eventbundle_event';
    }
}
