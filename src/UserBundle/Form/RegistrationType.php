<?php
namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;



class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('civilite', ChoiceType::class, array(
            'expanded' => true,
            'multiple' => false,
            'choices' => array(
                'Monsieur' => 'Monsieur',
                'Madame' => 'Madame',
            )
        ))
                ->add('nom')
                ->add('prenom')
                ->add('societe')
                ->add('poste')
                ->add('telephone')
            ->add('userExpert', ChoiceType::class, array(
                'label' => 'Expert métier : ',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    '0' => 'Non',
                    '1' => 'Oui',
                )))
            ->add('userVoix', ChoiceType::class, array(
                'label' => 'Comédien Audio : ',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    '0' => 'Non',
                    '1' => 'Oui',
                )))
            ->add('userContributeur', ChoiceType::class, array(
                'label' => 'Dessinateur : ',
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    '0' => 'Non',
                    '1' => 'Oui',
                )))

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