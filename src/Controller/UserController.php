<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends AbstractController
{

    /**
     * @Route("/userGeo", name="user_geo")
     * @return Response
     */
    public function index():Response
    {

        return $this->render('user/usersMap.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }

    /**
     * @Route("/AjaxUserGeo", name="ajax_user_geo")
     * @param Request $request
     */
    public function ajaxUsersList(Request $request):JsonResponse
    {
        // TODO secure ajax all request
        $repository = $this->getDoctrine()->getRepository(User::class);
        $allUsers = $repository->findAll();
        $geoUsers = [];
        foreach ($allUsers as $user){
            $geoUsers[] = ["username" => $user->getUsername(), "lat" => $user->getLatitude(), "long" => $user->getLongitude() ];
        }
        return new JsonResponse(
            $geoUsers,
            JsonResponse::HTTP_OK
        );
    }

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
