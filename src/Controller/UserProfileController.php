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
        
        if ($user == null){
            return $this->RedirectToRoute("homepage");
        }
        return $this->render('/user_profile/userpage.html.twig');
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
                $path = 'Profile/' . $user->getId() . '/';
                $pictName = 'profile';
                $extension = 'png';

                $img = $path . $pictName . '.' . $extension;
                $user->setImagePath($img);

                $file->move($path, $pictName . '.' . $extension);
            }
            
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('editUser');
        }
        return $this->render('/user_profile/editUser.html.twig', [
            'ProfileEditForm' => $form,
        ]);
    }

}
