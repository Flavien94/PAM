<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('dateStart', 'date', array(
              'widget' => "single_text",
              'required' => false
        ))
        ->add('timeStart', 'time', array(
              'widget' => "single_text",
              'required' => false
        ))
        ->add('dateEnd', 'date', array(
              'widget' => "single_text",
              'required' => false
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
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Search'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'event_eventbundle_search';
    }
}
