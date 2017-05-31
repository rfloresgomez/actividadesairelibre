<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Nombre'
        ])
            ->add('username', TextType::class, [
                'label' => 'Nombre de Usuario'
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Contraseña'
            ])
            ->add('mail', TextType::class, [
                'label' => 'Mail'
            ])
            ->add('redes', TextType::class, [
                'label' => 'Twitter'
            ])
            ->add('rol', ChoiceType::class, array(
                'choices'  => array(
                    'STANDARD' => 'STANDARD',
                    'EDITOR' => 'EDITOR',
                    'ADMIN' => 'ADMIN',
                ),))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Users'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_users';
    }


}
