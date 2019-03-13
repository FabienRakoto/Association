<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('pages/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/create", name="create_user")
     */
    
     public function create(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
         $user = new User;
         $form = $this->createForm(UserType::class, $user);
         $form->handleRequest($request);
         
         if($form->isSubmitted() && $form->isValid()){
             $hash = $encoder->encodePassword($user, $user->getPassword());
             $user->setPassword($hash);

             $manager->persist($user);
             $manager->flush();
           
         }

        

         return $this->render("pages/user/create.html.twig",[
             'form' => $form->createView()
         ]);
     }
}
