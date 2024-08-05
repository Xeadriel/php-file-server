<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\User;
use App\Form\ProfileEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserProfileController extends AbstractController
{
    #[Route('/userpage', name: 'userpage')]
    public function userpage(): Response
    {   
        $user = $this->getUser();
        $img = $user->getImagePath();
        if ($img == null){
            
        }
        return $this->render('/userpage.html.twig', [
            'imgPath' => $img,
            ''
        ]);
    }

    #[Route('/editUser', name: 'editUser')]
    public function editUser(EntityManagerInterface $entityManager,
                            Request $request): Response
    {   
        $user = $this->getUser();
        $form = $this->createForm(ProfileEditFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $file = $form['image_path']->getData();

            if ($file != null){
                $path = 'Profile/' . $user->getUsername() . '/';
                $pictName = 'profile';
                $extension = $file->guessExtension();

                if (!$extension){
                    $extension = 'png';
                }

                #$path = $path . $pictName . '.' . $extension;
                $user->setImagePath($path);

                $file->move($path, $pictName . '.' . $extension);
            }
            
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('editUser');
        }
        return $this->render('/editUser.html.twig', [
            'ProfileEditForm' => $form,
        ]);
    }

}
