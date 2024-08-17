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
                                #[Autowire('%kernel.project_dir%/Pictures/Profile/empty_pict/Default.png')] string $defaultPictPath
                                ): Response
    {   
        $user = $this->getUser();
        if($user == null || empty($user->getImagePath())){
            $image = file_get_contents($defaultPictPath);
        }
        else{
            $imagePath = $user->getImagePath();
            $image = file_get_contents($imagePath);
        }
        return new Response($image, 200, ['content-type' => 'image/png']);
    }
}
