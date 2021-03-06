<?php
namespace Users\UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('current_password');
        $builder->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
            'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => ' ',
                                      'attr' => array('placeholder' => 'form.new_password',
                                                      'class' => 'fosuser-input'
                                    )),
            'second_options' => array('label' => ' ',
                                      'attr' => array('placeholder' => 'form.new_password_confirmation',
                                                      'class' => 'fosuser-input'
                                    )),
            'invalid_message' => 'fos_user.password.mismatch',
        ));
    }

    public function getParent()
    {
        // return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        return 'fos_user_change_password';
    }

    public function getBlockPrefix()
    {
        return 'app_user_change_password';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
