<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user/posts", name="user_posts")
     * @return Response
     */
    public function PostsAction(Request $request):Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $id = $request->query->get('id');
        $user = $repository->find($id);

        return $this->render('user/postsList.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user
        ]);
    }
}
