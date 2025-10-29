<?php

declare(strict_types=1);

namespace FGTCLB\LlmsTxt\Tests\Unit\Service;

use FGTCLB\LlmsTxt\Service\ConfigurationService;
use FGTCLB\LlmsTxt\Service\LlmTxtGeneratorService;
use PHPUnit\Framework\TestCase;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

/**
 * Test case for ConfigurationService
 */
class ConfigurationServiceTest extends UnitTestCase
{
    private ConfigurationService $subject;

    protected function setUp(): void
    {
        parent::setUp();
        // Test setup would go here
    }

    /**
     * @test
     */
    public function canInstantiate(): void
    {
        self::assertInstanceOf(ConfigurationService::class, $this->subject ?? new ConfigurationService(
            $this->createMock(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class),
            $this->createMock(\TYPO3\CMS\Core\Site\SiteFinder::class)
        ));
    }
}
