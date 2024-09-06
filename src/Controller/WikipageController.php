<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\User;
use App\Form\EditPageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


class WikipageController extends AbstractController
{
	#[Route('/create', name: 'createpage')]
	public function createpage(Request $request): Response
	{   
		$form = $this->createForm(EditPageForm::class); //, $page);  for when editing
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$page = $form['wikiHtml']->getData();
			var_dump($page);
	//      add repo stuff to save html

	// 	 	redirect to page's link
		return $this->redirectToRoute('homepage');
	}
	return $this->render('/createpage/CreatePage.html.twig', [
				'EditPageForm' => $form,
		]);
	}
}
