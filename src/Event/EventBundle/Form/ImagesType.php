<?php

namespace Event\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
              'label' => 'Importer une image de couverture',
              'required' => false,
              'label_attr' => array(
                  'class' => 'strong',
              ),
              'attr' => array(
                'accept' => 'image/*',
              )
      ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Event\EventBundle\Entity\Images'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'event_eventbundle_images';
    }
}
