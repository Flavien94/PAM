<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact_name', 'text',array(
                  'required' => false
            ))
            ->add('contact_email', 'text',array(
                  'required' => false
            ))
            ->add('dateStart', 'date', array(
                  'widget' => "single_text",
                  'required' => true
            ))
            ->add('timeStart', 'time', array(
                  'widget' => "single_text",
                  'required' => false
            ))
            ->add('dateEnd', 'date', array(
                  'widget' => "single_text",
                  'required' => true
            ))
            ->add('timeEnd', 'time', array(
                  'widget' => "single_text",
                  'required' => false
            ))
            ->add('publics', 'collection', array(
                  'type'         => new PublicsType(),
                  'allow_add'    => true,
                  'allow_delete' => true,
                  'required' => false
                  ))
            ->add('publics', 'entity', array(
                  'class'    => 'EventBundle:Publics',
                  'choice_label' => 'title',
                  'multiple' => false,
                  'placeholder' => 'Public',
                  'required' => false
                  ))
            ->add('type', 'collection', array(
                  'type'         => new TypeType(),
                  'allow_add'    => true,
                  'allow_delete' => true,
                  'required' => false
                  ))
            ->add('type', 'entity', array(
                   'class'    => 'EventBundle:Type',
                   'choice_label' => 'title',
                   'multiple' => false,
                   'placeholder' => 'Type d\'évenement',
                   'required' => false
                  ))
            ->add('sector', 'collection', array(
                  'type'         => new SectorType(),
                  'allow_add'    => true,
                  'allow_delete' => true,
                  'required' => false
                  ))
            ->add('sector', 'entity', array(
                   'class'    => 'EventBundle:Sector',
                   'choice_label' => 'title',
                   'multiple' => false,
                   'placeholder' => 'Type de Secteur',
                   'required' => false
                  ))
              ->add('headlines','checkbox', array(
                    'required' => false
                  ))
              ->add('scratch','checkbox', array(
                    'required' => false
                  ))
              ->add('author','text',array(
                    'required' => false
              ))
              ->add('title','text', array(
                    'required' => true
              ))
              ->add('description','textarea', array(
                    'required' => true
              ))
              ->add('uploadedLinks', 'collection', array(
                   'type'         => new LinksType(),
                   'allow_add'    => true,
                   'allow_delete' => true,

                 ))
              ->add('place', new PlaceType(), array(
                    'required' => false
              ))
              ->add('images',new ImagesType(), array(
                    'required' => false,
                    'attr' => array(
                      'accept' => 'image/*',
                    )
              ))
              ->add('uploadedFiles', 'file', array(
                    'multiple' => true,
                    'data_class' => null,
                    'required' => false,
                    'attr' => array(
                      'accept' => 'application/pdf,image/*',
                    )
                  ))
              ;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Event',
            'error_bubbling' => true
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
