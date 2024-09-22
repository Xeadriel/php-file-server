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
use Symfony\Component\DependencyInjection\Attribute\Autowire;


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
                            Request $request,
                            #[Autowire('%kernel.project_dir%/Pictures/Profile/')] string $ppDir): Response
    {   
        $user = $this->getUser();
        if ($user == null){
            return $this->RedirectToRoute("homepage");
        }
        $form = $this->createForm(ProfileEditFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $file = $form['image_path']->getData();
            $imageArray = explode(";", $file);
            $imageContents = explode(",", $imageArray[1]);
            $file = base64_decode($imageContents[1]);

            if ($file != null){
                $imgPath = $user->getId() . '/';
                $pictName = 'profile';
                $extension = 'png';

                $img = $imgPath . $pictName . '.' . $extension;
                $user->setImagePath($img);

                //$file->move($ppDir . $imgPath, $pictName . '.' . $extension);
                $path = $ppDir . $imgPath . $pictName . '.' . $extension;
                file_put_contents($path, $file);
            }
            
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('editUser');
        }
        return $this->render('/user_profile/editUser.html.twig', [
            'ProfileEditForm' => $form,
        ]);
    }


    #[Route('/deletePP', name: 'deletePP')]
    public function deletePP(EntityManagerInterface $em): Response
    {   
        $user = $this->getUser();
        if ($user == null){
            return $this->RedirectToRoute("homepage");
        }
        $user->setImagePath("");

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute("editUser");
    }
}
