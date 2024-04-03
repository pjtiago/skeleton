<?php

namespace App\Controller;

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
}