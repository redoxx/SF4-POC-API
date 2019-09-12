<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UsersImport
{
    private $usersEndpoint;
    private $em;

    /**
     * UsersImport constructor.
     * @param $usersEndpoint
     * @param EntityManagerInterface $em
     */
    public function __construct($usersEndpoint, EntityManagerInterface $em)
    {
        $this->usersEndpoint = $usersEndpoint;
        $this->em = $em;
    }

    /**
     * Import Users from REST WS Endpoint
     * @return array|string
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function importNewUsers()
    {
        try
        {
            $client = HttpClient::create();
            $response = $client->request('GET', $this->usersEndpoint);
            $content = $response->toArray();
            //Insert all users
            $this->creatNewUsers($content);
            return TRUE;
        } catch (RequestException $e) {
            if (200 !== $e->getResponse()->getStatusCode()) {
                return $e->getMessage();
            }
            throw $e;
        }
    }

    /**
     * Insert users in DB
     * @param $users array
     *
     */
    public function creatNewUsers($users)
    {
        foreach ($users as $u)
        {
            $user = new User();
            $user->setName($u['name']);
            $user->setUsername($u['username']);
            $user->setEmail($u['email']);
            $user->setAddress1($u['address']['street']);
            $user->setAddress2($u['address']['suite']);
            $user->setCity($u['address']['city']);
            $user->setZipcode($u['address']['zipcode']);
            $user->setLatitude($u['address']['geo']['lat']);
            $user->setLongitude($u['address']['geo']['lng']);
            $user->setPhone($u['phone']);
            $user->setWebsite($u['website']);
            $user->setCompanyName($u['company']['name']);
            $user->setCompanyCatchPhrase($u['company']['catchPhrase']);
            $user->setCompanyBs($u['company']['bs']);
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}