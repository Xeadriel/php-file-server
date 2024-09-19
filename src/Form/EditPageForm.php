<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditPageForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('wikiHtml', HiddenType::class)
			->add('wikiPageName', TextType::class,
					['label' => 'Page Name']
				)
			->add('wikiPageCategory', ChoiceType::class,
					['label' => 'Category', 'choices' => [
						'Character Creation' => 'Character Creation', 'Lore' => 'Lore', 'Geography' => 'Geography', 'Rules' => 'Rules', 'Combat Rules' => 'Combat Rules', 'Other' => 'Other'],
					'placeholder' => 'Select a category']
				)
			->add('wikiPageTags', TextType::class,
					['label' => 'Tags (comma separated)', 'required'   => false]
				)
			->add('save', SubmitType::class, 
					['label' => 'Save']
				)
			;
	}

	// public function configureOptions(OptionsResolver $resolver): void
	// {
	// 	$resolver->setDefaults([
	// 		'data_class' => Page::class,
	// 	]);
	// }
}
