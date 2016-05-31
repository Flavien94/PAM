<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact_name', 'text')
            ->add('contact_email', 'text')
            ->add('dateStart', 'datetime', array(
                  'date_widget' => "single_text",
                  'time_widget' => "single_text"
            ))
            ->add('dateEnd', 'datetime', array(
                  'date_widget' => "single_text",
                  'time_widget' => "single_text"
            ))
            ->add('publics', 'collection', array(
                  'type'         => new PublicsType(),
                  'allow_add'    => true,
                  'allow_delete' => true
                  ))
            ->add('publics', 'entity', array(
                  'class'    => 'EventBundle:Publics',
                  'choice_label' => 'title',
                  'multiple' => false,
                  'placeholder' => 'Public'
                  ))
            ->add('type', 'collection', array(
                  'type'         => new TypeType(),
                  'allow_add'    => true,
                  'allow_delete' => true
                  ))
            ->add('type', 'entity', array(
                   'class'    => 'EventBundle:Type',
                   'choice_label' => 'title',
                   'multiple' => false,
                   'placeholder' => 'Type d\'évenement'
                  ))
            ->add('sector', 'collection', array(
                  'type'         => new SectorType(),
                  'allow_add'    => true,
                  'allow_delete' => true
                  ))
            ->add('sector', 'entity', array(
                   'class'    => 'EventBundle:Sector',
                   'choice_label' => 'caption',
                   'multiple' => false,
                   'placeholder' => 'Type de Secteur'
                  ))
              ->add('headlines','checkbox', array(
                    'required' => false
                  ))
              ->add('author')
              ->add('title')
              ->add('description')
              ->add('links', 'collection', array(
                   'type'         => new LinksType(),
                   'allow_add'    => true,
                   'allow_delete' => true
                 ))
              ->add('place')
              ->add('images',new ImagesType())
              ->add('uploadedFiles', 'file', array(
                    'multiple' => true,
                    'data_class' => null,
                    'required' => false,
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
