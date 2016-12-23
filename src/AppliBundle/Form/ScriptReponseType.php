<?php

namespace AppliBundle\Form;

use AppliBundle\Entity\ScriptQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ScriptQuestionType;

class ScriptReponseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('reponse', CollectionType::class, array(
            // each entry in the array will be an "question" field
            'entry_type'   => ScriptQuestionType::class,
            // these options are passed to each "email" type
            'entry_options'  => array(
                'attr'      => array('class' => 'reponse-question')
            ),
        ));



//        $builder->add('reponse')->add('script')->add('question')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppliBundle\Entity\ScriptReponse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'applibundle_scriptreponse';
    }


}
