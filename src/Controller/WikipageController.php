<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\User;
use App\Entity\WikiPage;
use App\Repository\WikiPageRepository;
use App\Form\EditPageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\Attribute\Autowire;


class WikipageController extends AbstractController
{
	#[Route('/create', name: 'createpage')]
	public function createpage(
		WikiPageRepository $wikiPageRepository, Request $request,
		#[Autowire('%kernel.project_dir%/WikiPages/')] string $htmlDirectory): Response
	{   
		$form = $this->createForm(EditPageForm::class); //, $page);  for when editing
		$form->handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			
			$user = $this->getUser();
			
			$page = $form['wikiHtml']->getData();
			$pageName = $form['wikiPageName']->getData();
			$pageCategory = $form['wikiPageCategory']->getData();			
			$pageTags = $form['wikiPageTags']->getData();

			$wikiPage = new WikiPage();
			
			$wikiPage->setCreator($user);
			$wikiPage->setRawHTMLPath('temporary path');
			$wikiPage->setCreationDate(new \DateTime("now", new \DateTimeZone("UTC")));
			$wikiPage->setLastModifiedDate(new \DateTime("now", new \DateTimeZone("UTC")));
			$wikiPage->setName($pageName);
			$wikiPage->setCategory($pageCategory);
			$wikiPage = $wikiPageRepository->saveWikiPage($wikiPage);
			// TODO tags
			// TODO category

			$pagePath = $pageName . $wikiPage->getId() . ".html";
			
			$htmlFile = fopen($htmlDirectory . $pagePath, "w");
			fwrite($htmlFile, $page);
			fclose($htmlFile);
            
			$wikiPage->setRawHTMLPath($pagePath);

			$wikiPage = $wikiPageRepository->saveWikiPage($wikiPage);

			// TODO redirect to page
			return $this->redirectToRoute('wikipage', ['category' => $pageCategory, 'id' => $wikiPage->getId()]);
	}
	return $this->render('/WikiPage/CreatePage.html.twig', [
				'EditPageForm' => $form,
		]);
	}

	#[Route('/page/{category}/{id}', name: 'wikipage')]
	public function wikipage(
		WikiPageRepository $wikiPageRepository, Request $request,
		#[Autowire('%kernel.project_dir%/WikiPages/')] string $htmlDirectory,
		$id): Response
	{   
		$wikiPage = $wikiPageRepository->findPageById($id);

		if($wikiPage == null){
			return $this->redirectToRoute('homepage');
		}

		$pagePath = $htmlDirectory . $wikiPage->getRawHTMLPath();

		if(file_exists($pagePath)){
			$rawHTMLContent = file_get_contents($pagePath);
		}else{
			$rawHTMLContent = "Page not found";
		}

		return $this->render('/WikiPage/WikiPage.html.twig', [
				'title' => $wikiPage->getName(),
				'wikiPage' => $rawHTMLContent,
		]);
	}

	// #[Route('/edit/{id}', name: 'editpage')]
	// public function editpage(
	// 	WikiPageRepository $wikiPageRepository, Request $request,
	// 	#[Autowire('%kernel.project_dir%/WikiPages/')] string $htmlDirectory,
	// 	$id): Response
	// {   
	// 	$wikiPage = $wikiPageRepository->findPageById($id);

	// 	if($wikiPage == null){
	// 		return $this->redirectToRoute('homepage');
	// 	}

	// 	$form = $this->createForm(EditPageForm::class, $wikiPage);
	// 	$form->handleRequest($request);

	// 	if($form->isSubmitted() && $form->isValid()){
	// 		$user = $this->getUser();

	// 		$page = $form['wikiHtml']->getData();
	// 		$pageName = $form['wikiPageName']->getData();
	// 		$pageTags = $form['wikiPageTags']->getData();
	// 		$pageCategory = $form['wikiPageCategory']->getData();

	// 		$wikiPage->setLastModifiedDate(new \DateTime("now", new \DateTimeZone("UTC")));
	// 		$wikiPage = $wikiPageRepository->saveWikiPage($wikiPage);

	// 		$pagePath = $htmlDirectory . $wikiPage->getRawHTMLPath();

	// 		$htmlFile = fopen($pagePath, "w");
	// 		fwrite($htmlFile, $page);
	// 		fclose($htmlFile);

	// 		// TODO tags
	// 		// TODO category

	// 		// TODO redirect to page
	// 		return $this->redirectToRoute('homepage');
	// 	}

	// 	return $this->render('/WikiPage/EditPage.html.twig', [
	// 			'EditPageForm' => $form,
	// 			'wikiPage' => $wikiPage,
	// 	]);
	// }

}
