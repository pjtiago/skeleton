<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MyController
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    #[Route('/randomNumber', name: 'random_number')]
    public function number(): JsonResponse
    {
        $number = $this->cache->get('test_cache', function (ItemInterface $item): string {

            $item->expiresAfter(5);

            var_dump('miss');
            return random_int(0, 5);
        });

        return new JsonResponse(
            [
                'number' => $number
            ]
        );
    }

    #[Route('/user', name: 'create_user')]
    public function createProduct(EntityManagerInterface $entityManager): JsonResponse
    {
        $user = new User();
        $user->setName(base64_encode(random_bytes(10)))
            ->setEmail(base64_encode(random_bytes(10)))
            ->setActive(1);

        $entityManager->persist($user);

        $entityManager->flush();

        return new JsonResponse(
            [
                'Success' => 'Saved new product with id ' . $user->getId()
            ]
        );
    }
}