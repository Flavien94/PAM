<?php
namespace Users\UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->remove('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
        ->add('username', null, array('label' => ' ', 'translation_domain' => 'FOSUserBundle',
                                      'attr' => array('placeholder' => 'form.username',
                                                      'class' => 'fosuser-input'
                                    ),
                                ))
        ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
            'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => ' ',
                                    'attr' => array('placeholder' => 'form.password',
                                                    'class' => 'fosuser-input'
                                  ),
                                ),
            'second_options' => array('label' => ' ',
                                      'attr' => array('placeholder' => 'Confirmer le mot de passe',
                                                      'class' => 'fosuser-input'
                                    ),
                                  ),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }

    public function getParent()
    {
        // return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
