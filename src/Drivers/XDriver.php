<?php

namespace Anibalealvarezs\XHubDriver\Drivers;

use Anibalealvarezs\ApiDriverCore\Interfaces\SyncDriverInterface;
use Anibalealvarezs\ApiDriverCore\Interfaces\AuthProviderInterface;
use Anibalealvarezs\ApiDriverCore\Traits\HasUpdatableCredentials;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use DateTime;
use Anibalealvarezs\ApiDriverCore\Interfaces\SeederInterface;
use Anibalealvarezs\ApiDriverCore\Traits\SyncDriverTrait;
use Anibalealvarezs\ApiDriverCore\Interfaces\CanonicalMetricDictionaryProviderInterface;
use Anibalealvarezs\ApiDriverCore\Interfaces\AggregationProfileProviderInterface;
use Anibalealvarezs\ApiDriverCore\Classes\AggregationProfileTemplates;

class XDriver implements SyncDriverInterface, CanonicalMetricDictionaryProviderInterface, AggregationProfileProviderInterface
{
    use SyncDriverTrait;

    public static function getAggregationProfiles(): array
    {
        return [
            AggregationProfileTemplates::adsHierarchyProfile(
                channel: 'x',
                key: 'x_ads',
                label: 'X Ads Performance'
            ),
        ];
    }

    /**
     * Store credentials for this driver.
     * 
     * @param array $credentials
     * @return void
     */
    public static function storeCredentials(array $credentials): void
    {
        // No implementation needed for this driver
    }

    /**
     * Get the public resources exposed by this driver.
     * 
     * @return array
     */
    public static function getPublicResources(): array
    {
        return [];
    }

    /**
     * Get the display label for the channel.
     * 
     * @return string
     */
    public static function getChannelLabel(): string
    {
        return 'X';
    }

    /**
     * Get the display icon for the channel.
     * 
     * @return string
     */
    public static function getChannelIcon(): string
    {
        return 'X';
    }

    /**
     * Get the routes served by this driver.
     * 
     * @return array
     */
    public static function getRoutes(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function fetchAvailableAssets(bool $throwOnError = false): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthentication(): array
    {
        return [
            'success' => true,
            'message' => 'Status unknown for this driver.',
            'details' => []
        ];
    }

    public static function getCommonConfigKey(): ?string
    {
        return null;
    }

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

    public function getAuthProvider(): ?AuthProviderInterface
    {
        return $this->authProvider;
    }

    public function getChannel(): string
    {
        return 'x';
    }

    public function sync(
        DateTime $startDate,
        DateTime $endDate,
        array $config = [],
        ?callable $shouldContinue = null,
        ?callable $identityMapper = null
    ): Response

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

    /**
     * @inheritdoc
     */
    public function getConfigSchema(): array
    {
        return [
            'global' => [
                'enabled' => false,
                'cache_history_range' => '30 days',
                'cache_aggregations' => false,
            ],
            'entity' => [
                'enabled' => true,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateConfig(array $config): array
    {
        return \Anibalealvarezs\ApiDriverCore\Services\ConfigSchemaRegistryService::hydrate(
            $this->getChannel(),
            'global',
            $config,
            $this->getConfigSchema()
        );
    }

    /**
     * @inheritdoc
     */
    public function seedDemoData(SeederInterface $seeder, array $config = []): void
    {
        // Placeholder for future implementation
    }
    public function boot(): void
    {
    }

    /**
     * @inheritdoc
     */
    public static function getAssetPatterns(): array
    {
        return [
            'twitter_profile' => [
                'prefix' => 'tw:profile',
                'hostnames' => ['twitter.com', 'x.com'],
                'url_id_regex' => null
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getPageTypes(): array
    {
        return [
            'twitter_profile' => 'Twitter Profile'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getAccountTypes(): array
    {
        return [
            'twitter_profile' => 'Twitter Profile'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getEntityPaths(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getCanonicalMetricDictionary(): array
    {
        return [
            'spend' => ['spend'],
            'clicks' => ['clicks'],
            'impressions' => ['impressions'],
            'reach' => ['reach'],
            'conversions' => ['conversion'],
        ];
    }

    public static function getPlatformEntityIdField(): string
    {
        return 'id';
    }

    /**
     * @inheritdoc
     */
    public function initializeEntities(array $config = []): array

    {
        return ['initialized' => 0, 'skipped' => 0];
    }

    /**
     * @inheritdoc
     */
    public function reset(string $mode = 'all', array $config = []): array

    {
        return ['cleared' => 0, 'mode' => $mode];
    }

    public function updateConfiguration(array $newData, array $currentConfig): array
    {
        return $currentConfig;
    }

    public function prepareUiConfig(array $channelConfig): array
    {
        return [];
    }
    /**
     * @inheritdoc
     */
    public function getDateFilterMapping(): array
    {
        return [];
    }
}


