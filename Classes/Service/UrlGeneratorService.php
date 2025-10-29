<?php

declare(strict_types=1);

namespace FGTCLB\LlmsTxt\Service;

/**
 * Service for generating URLs
 */
class UrlGeneratorService
{
    public function __construct(
        private readonly ConfigurationService $configurationService
    ) {}

    /**
     * Generate absolute URL for a page
     */
    public function generatePageUrl(int $pageUid): string
    {
        $siteUrl = $this->configurationService->getSiteUrl();

        // Fallback to simple URL construction
        // TODO: Implement pretty URLs using TYPO3 Site Router when Request object is available
        return rtrim($siteUrl, '/') . '/?id=' . $pageUid;
    }
}
