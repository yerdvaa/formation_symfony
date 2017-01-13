<?php

namespace adminBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('quantity')
            ->add('marque', EntityType::class,[
                'class' => 'adminBundle\Entity\Brand',
                'choice_label' => 'title',
                'placeholder' => ''
                /*'expanded' => true,
                'multiple' => true*/
                ])
            ->add('categories', EntityType::class,[
                  'class' => 'adminBundle\Entity\Categorie',
                  'choice_label' => 'title',
                  'placeholder' => '',
                  'expanded' => true,
                  'multiple' => true
            ])
            ->add('image', FileType::class, [
                'data_class' => null
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'adminBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminBundle_product';
    }


}
