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
            ->add('publics', 'entity', array('class' => 'Event\EventBundle\Entity\Publics',
            'property' => 'title',
            'multiple' => false,
            'empty_value' => 'Public'))
            ->add('type', 'entity', array('class' => 'Event\EventBundle\Entity\Type',
            'property' => 'title',
            'multiple' => false,
            'empty_value' => 'Type d\'évenement'))
            ->add('sector', 'entity', array('class' => 'Event\EventBundle\Entity\Sector',
            'property' => 'title',
            'multiple' => false,
            'empty_value' => 'Secteurs'))
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
