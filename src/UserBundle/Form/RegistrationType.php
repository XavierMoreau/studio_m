<?php
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('roles', 'collection', array(
                        'type' => 'choice',
                        'options' => array(
                            'label' => false, /* Ajoutez cette ligne */
                            'choices' => array(
                                    'ROLE_USER' => 'Utilisateur',
                                    'ROLE_EXPERT' => 'Expert',
                                    'ROLE_CONTRIBUTEUR' => 'Contributeur'
                        )
                    )
                )
            )
        ;
    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
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