<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        // Utiliser la bibliothèque "symfony/intl" pour obtenir la liste des pays
        $countryCodes = Countries::getNames();

        $countries = array_combine($countryCodes, $countryCodes);

        $builder
            ->add('full_name', null, [
                'label' => 'Prénom et NOM',
                'constraints' => new NotBlank(),
            ])
            ->add('societe_name', null, [
                'label' => 'Entreprise',
                'required' => false, // Ce champ n'est pas obligatoire
            ])
            ->add('address', null, [
                'label' => 'Adresse',
                'attr' => ['class' => 'custom-input-style'],
                'constraints' => new NotBlank(),
            ])
            ->add('postal', null, [
                'label' => 'Code postal',
                'attr' => ['class' => 'custom-input-style'],
                'constraints' => new NotBlank(),
            ])
            ->add('address_complement', null, [
                'label' => 'Complément d\'adresse',
                'attr' => ['class' => 'custom-input-style'],
                'constraints' => new NotBlank(),
            ])
            ->add('ville', null, [
                'label' => 'Ville',
                'attr' => ['class' => 'custom-input-style'],
                'constraints' => new NotBlank(),
            ])

            ->add('pays', ChoiceType::class, [
                'label' => 'Pays',
                'attr' => ['class' => 'custom-input-style'],
                'choices' => $countries,
                'data' => 'France',
                'constraints' => new NotBlank(),
            ])

            ->add('phone', null, [
                'label' => 'Téléphone',
                'attr' => ['class' => 'custom-input-style'],
                'constraints' => new NotBlank(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
