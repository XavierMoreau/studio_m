<?php

namespace AppliBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomProjet','text',array('label'=>'Nom du projet :'))
                ->add('support',
                    EntityType::class, array(
                    'class' => 'AppliBundle:Support',
                    'choice_label' => 'supportType',
                    'multiple' => true,
                    'expanded' => true,
                        'label'=>'Type de support :')
                )
                ->add('diffusion',
                    EntityType::class, array(
                    'class' => 'AppliBundle:Diffusion',
                    'choice_label' => 'diffusionType',
                    'multiple' => true,
                    'expanded' => true,
                        'label'=>'Type de diffusion :')
                )
                ->add('utilisation',
                    EntityType::class, array(
                    'class' => 'AppliBundle:Utilisation',
                    'choice_label' => 'utilisationType',
                    'multiple' => true,
                    'expanded' => true,
                        'label'=>"Type d'utilisation :")
                )
            ->add('dateDiffusion','date',array('label'=>'Date de diffusion prévue :',
                'attr' => array('min' => '01-01-2017')))
            ->add('tempsDiffusion','integer',
                array('label'=>'Temps de diffusion (en années) :',
                'attr' => array('placeholder' => '00', 'min' => '0')))



            ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildVoixOffForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('voixoffGlobal','text',array('label'=>''));
    }




    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppliBundle\Entity\Projet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'applibundle_projet';
    }


}
