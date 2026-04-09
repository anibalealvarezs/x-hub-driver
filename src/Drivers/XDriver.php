<?php

namespace Anibalealvarezs\XHubDriver\Drivers;

use Anibalealvarezs\ApiSkeleton\Interfaces\SyncDriverInterface;
use Anibalealvarezs\ApiSkeleton\Interfaces\AuthProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use DateTime;

class XDriver implements SyncDriverInterface
{
    private ?AuthProviderInterface $authProvider = null;
    private ?LoggerInterface $logger = null;

    public function __construct(?AuthProviderInterface $authProvider = null, ?LoggerInterface $logger = null)
    {
        $this->authProvider = $authProvider;
        $this->logger = $logger;
    }

    public function setAuthProvider(AuthProviderInterface $provider): void
    {
        $this->authProvider = $provider;
    }

    public function getChannel(): string
    {
        return 'x';
    }

    public function sync(DateTime $startDate, DateTime $endDate, array $config = []): Response
    {
        if ($this->logger) {
            $this->logger->info("XDriver (Modular): No native implementation yet. Sync skipped.");
        }
        
        return new Response(json_encode([
            'status' => 'skipped',
            'message' => 'X modular driver placeholder executed successfully.'
        ]));
    }
    public function getApi(array $config = []): mixed
    {
        return null;
    }
}

