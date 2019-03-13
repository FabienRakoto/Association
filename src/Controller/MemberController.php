<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    
     public function create(){
         return $this->render("pages/member/create.html.twig");
     }
}
