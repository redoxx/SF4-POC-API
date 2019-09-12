<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Post;

class PostsImport
{
    private $postsEndpoint;
    private $em;

    public function __construct($postsEndpoint, EntityManagerInterface $em)
    {
        $this->postsEndpoint = $postsEndpoint;
        $this->em = $em;
    }

    /**
     * Import Post from REST WS Endpoint
     * @return array|string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function importNewPosts()
    {
        try
        {
            $client = HttpClient::create();
            $response = $client->request('GET', $this->postsEndpoint);
            $content = $response->toArray();

            //Insert all posts
            $this->creatNewPosts($content);
            return TRUE;
        } catch (RequestException $e) {
            if (200 !== $e->getResponse()->getStatusCode()) {
                return $e->getMessage();
            }
            throw $e;
        }
    }

    /**
     * Insert posts in DB
     * @param $users array
     *
     */
    public function creatNewPosts($posts)
    {
        foreach ($posts as $p)
        {
            $userRepo = $this->em->getRepository(User::class);
            $user = $userRepo->find($p['userId']);
            if ($user instanceof User){
                $post = new Post();
                $post->setTitle($p['title']);
                $post->setBody($p['body']);
                $post->setUser($user);
                $this->em->persist($post);
                $this->em->flush();
            }
        }
    }
}