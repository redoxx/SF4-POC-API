<?php
namespace App\EventListener;


use http\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class DeletePost
{
    private $postDeleteEndpoint;

    /**
     * DeletePost constructor.
     * @param $postDeleteEndpoint
     */
    public function __construct($postDeleteEndpoint)
    {
        $this->postDeleteEndpoint = $postDeleteEndpoint;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if (!$entity instanceof Post) {
            return;
        }
        $entityManager = $args->getObjectManager();
        // Delete remote Post
        $client = HttpClient::create();
        $response = $client->request('DELETE', $this->postDeleteEndpoint);
        if (200 !== $response->getStatusCode()) {
            throw new \HttpRequestException("DELETE ERROR" . $response->getStatusCode());
        }

    }
}
