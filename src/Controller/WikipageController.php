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

			$pagePath = $pageName . $wikiPage->getId() . ".html";
			
			$htmlFile = fopen($htmlDirectory . $pagePath, "w");
			fwrite($htmlFile, $page);
			fclose($htmlFile);
            
			$wikiPage->setRawHTMLPath($pagePath);

			$wikiPage = $wikiPageRepository->saveWikiPage($wikiPage);

			return $this->redirectToRoute('wikipage', ['category' => $pageCategory, 'id' => $wikiPage->getId()]);
		}
		return $this->render('/WikiPage/CreatePage.html.twig', [
					'EditPageForm' => $form,
			]);
	}

	#[Route('/browse/{category}/{id}', name: 'wikipage')]
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
				'id' => $wikiPage->getId(),
		]);
	}

	#[Route('/edit/{id}', name: 'editpage')]
	public function editpage(
		WikiPageRepository $wikiPageRepository, Request $request,
		#[Autowire('%kernel.project_dir%/WikiPages/')] string $htmlDirectory,
		$id): Response
	{   
		$wikiPage = $wikiPageRepository->findPageById($id);

		if($wikiPage == null){
			return $this->redirectToRoute('homepage');
		}

		$form = $this->createForm(EditPageForm::class);
		$form->handleRequest($request);

		$pagePathOld = $htmlDirectory . $wikiPage->getRawHTMLPath();
		
		if(file_exists($pagePathOld)){
			$page = file_get_contents($pagePathOld);
		}else{
			$page = "Page not found";
		}
		

		if(!($form->isSubmitted() && $form->isValid())){

			$pageName = $form['wikiPageName']->setData($wikiPage->getName());
			$form['wikiHtml']->setData($page);
			$pageCategory = $form['wikiPageCategory']->setData($wikiPage->getCategory());
			// $pageTags = $form['wikiPageTags']->setData($wikiPage->getTags());
		}


		if($form->isSubmitted() && $form->isValid()){
			$user = $this->getUser();

			$page = $form['wikiHtml']->getData();
			$pageName = $form['wikiPageName']->getData();
			$pageTags = $form['wikiPageTags']->getData();
			$pageCategory = $form['wikiPageCategory']->getData();

			$pagePath = $htmlDirectory . $pageName . $wikiPage->getId() . ".html";
			if (! ($pagePathOld == $pagePath)) {
				unlink($pagePathOld);
			}

			$wikiPage->setRawHTMLPath($pageName . $wikiPage->getId() . ".html");
			$wikiPage->setLastModifiedDate(new \DateTime("now", new \DateTimeZone("UTC")));
			$wikiPage->setName($pageName);
			$wikiPage->setCategory($pageCategory);
			// tags

			$wikiPage->setLastModifiedDate(new \DateTime("now", new \DateTimeZone("UTC")));
			$wikiPage = $wikiPageRepository->saveWikiPage($wikiPage);


			$htmlFile = fopen($pagePath, "w");
			fwrite($htmlFile, $page);
			fclose($htmlFile);

			return $this->redirectToRoute('wikipage', ['category' => $pageCategory, 'id' => $wikiPage->getId()]);
		}

		return $this->render('/WikiPage/EditPage.html.twig', [
				'EditPageForm' => $form,
				'wikiPage' => $wikiPage,
		]);
	}

}
