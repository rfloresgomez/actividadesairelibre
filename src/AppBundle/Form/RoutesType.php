<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RoutesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('owner')
            ->add('name')
            ->add('description')
            ->add('city')
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'Asfalto' => 'Asfalto',
                    'Vía verde' => 'Vía Verde',
                    'Camino mozárabe' => 'Camino mozárabe',
                    'Trail' => 'Trail',
                    'Montaña' => 'Montaña',
                ),))
            ->add('dificult', ChoiceType::class, array(
                'choices'  => array(
                    'Fácil' => 'Fácil',
                    'Media' => 'Media',
                    'Dificil' => 'Dificil',
                ),))
            ->add('date', DateType::class, array(
                "required" => false))
            ->add('image', FileType::class,array(
                "label" => "Imagen:",
                "attr" =>array("class" => "form-control"),
                "required" => false))
            ->add('memo')
            ->add('createdDate')
            ->add('updatedDate');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Routes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_routes';
    }


}
