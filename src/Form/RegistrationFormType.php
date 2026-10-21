<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'E-mail'])
			->add('plainPassword', RepeatedType::class, ['type' => PasswordType::class,
			'first_options' => ['label' => 'Hasło', 'attr' =>
			['autocomplete' => 'new-password']],
			'second_options' => ['label' => 'Powtórz hasło', 'attr' =>
			['autocomplete' => 'new-password']],
			'invalid_message' => 'Hasła nie są takie same.',
			'mapped' => false,
			'constraints' => [new NotBlank(message: 'Podaj hasło. ',), new Length(min: 6,
			minMessage: 'Hasło musi mieć co najmniej {{ limit }} znaków. ', max: 4096,),],
			]),
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
