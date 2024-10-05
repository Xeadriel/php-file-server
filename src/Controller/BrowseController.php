<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\WikiPageRepository;
use App\Entity\WikiPage;

class BrowseController extends AbstractController
{
    #[Route('/browse', name: 'browse')]
    public function browse(): Response
    {
		$categoryArray = array("Character Creation", "Lore", "Geography", "Rules", "Combat Rules", "Other");

        return $this->render('browse/browse.html.twig', [
            'categories' => $categoryArray
        ]);
    }

	#[Route('/browse/{category}', name: 'categories')]
    public function categories(WikiPageRepository $wikiPageRepository, string $category): Response
    {
		$wikiPages = $wikiPageRepository->findPagesByCategory($category);

        return $this->render('browse/categories.html.twig', [
            'wikiPages' => $wikiPages,
        ]);
    }
}
