<?php

namespace adminBundle\Form;

use adminBundle\Form\Type\HTMLEditorType;
use adminBundle\Subscriber\CategoryFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', HTMLEditorType::class)
                //->add('description')
                ->add('position')
                ->add('active')
        ;

        $builder->addEventSubscriber(new CategoryFormSubscriber());
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'adminBundle\Entity\Categorie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_categorie';
    }


}
