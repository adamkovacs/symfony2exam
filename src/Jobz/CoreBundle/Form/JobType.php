<?php

namespace Jobz\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class JobType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company')
            ->add('category', 'entity', array(
                'label' => 'Category',
                'class' => 'Jobz\CoreBundle\Entity\Category',
                'choice_label' => 'categoryName'
            ))
            ->add('position')
            ->add('type', 'choice', array(
                'choices'  => array(
                    'Full-time' => 'Full-time',
                    'Part-time' => 'Part-time',
                    'Freelance' => 'Freelance',
                ),
            ))
            ->add('location')
            ->add('url')
            ->add('jobDescription', 'textarea')
            ->add('howToApply')
            ->add('email');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jobz\CoreBundle\Entity\Job'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jobz_corebundle_job';
    }


}
