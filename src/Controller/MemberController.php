<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Member;
use App\Form\MemberType;

class MemberController extends AbstractController
{
   /**
     * @Route("/member", name="member")
     */
    public function index()
    {
        return $this->render('pages/member/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/member/create", name="create_member")
     */
    
     public function create(Request $request, ObjectManager $manager){

        $membre = new Member;
        $form = $this->createForm(MemberType::class, $membre);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $file=$membre->getAvatar();
          $fileName = md5(uniqid()).'.'.$file->guessExtension();
          $file->move($this->getParameter('upload_diretory'),$fileName);
          
          $membre->setAvatar($fileName);
          $membre ->setCreatedAt(new \DateTime());

          $manager->persist($membre);
          $manager->flush();

          return $this->redirectToRoute('member');

        }

         return $this->render("pages/member/create.html.twig",[
             'form' => $form->createView() 
         ]);
         
     }
}
