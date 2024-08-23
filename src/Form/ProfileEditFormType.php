<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfileEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username: '
                ])

            #->add('roles')

            #->add('password', PasswordType::class, ['label' => 'Password: '])

            ->add('email', EmailType::class, [
                'label' => 'Email: '
                ])

            ->add('image_path', FileType::class, [
                'label' => 'Change Profile Picture: ',
                'data_class' => null,
                'required' => false
                ])

            ->add('save', SubmitType::class, [
                'label' => 'save changes'
                ])
        ;
    }

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}
