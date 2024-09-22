<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ProfilePictController extends AbstractController
{
    #[Route('/profile/{name}/pp', name: 'profilePict', methods: "GET")]
    public function profilePict(string $name,
                                #[Autowire('%kernel.project_dir%/Pictures/Profile/')] string $pictPath
                                ): Response
    {   
        $user = $this->getUser();
        if($user == null || empty($user->getImagePath())){
            $defaultPictPath = $pictPath . "empty_pict/Default.png";
            $image = file_get_contents($defaultPictPath);
        }
        else{
            $imagePath = $pictPath . $user->getImagePath();
            $image = file_get_contents($imagePath);
        }
        $response = new Response($image, 200, ['content-type' => 'image/png']);
        $response->setCache(['no_cache' => true]);
        return $response;
    }
}
