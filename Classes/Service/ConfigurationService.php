<?php

declare(strict_types=1);

namespace FGTCLB\LlmsTxt\Service;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service for managing extension configuration
 */
class ConfigurationService
{
    public function __construct(
        private readonly SiteFinder $siteFinder
    ) {}

    /**
     * Get the current site
     */
    protected function getCurrentSite(): ?Site
    {
        $sites = $this->siteFinder->getAllSites();
        if (empty($sites)) {
            return null;
        }

        return reset($sites);
    }

    /**
     * Get the main site URL
     */
    public function getSiteUrl(): string
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST');
        }

        return (string)$site->getBase();
    }

    /**
     * Get the main site name
     */
    public function getSiteName(): string
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return 'Website';
        }

        return $site->getIdentifier();
    }

    /**
     * Check if llms.txt generation is enabled
     */
    public function isEnabled(): bool
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return true;
        }

        return (bool)($site->getConfiguration()['llmsTxtEnabled'] ?? true);
    }

    /**
     * Get custom title override
     */
    public function getTitleOverride(): ?string
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return null;
        }

        $title = $site->getConfiguration()['llmsTxtTitle'] ?? '';
        return !empty($title) ? trim($title) : null;
    }

    /**
     * Get custom description override
     */
    public function getDescriptionOverride(): ?string
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return null;
        }

        $description = $site->getConfiguration()['llmsTxtDescription'] ?? '';
        return !empty($description) ? trim($description) : null;
    }

    /**
     * Get additional markdown content
     */
    public function getAdditionalInfo(): ?string
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return null;
        }

        $info = $site->getConfiguration()['llmsTxtAdditionalInfo'] ?? '';
        return !empty($info) ? trim($info) : null;
    }

    /**
     * Get contact email
     */
    public function getContactEmail(): ?string
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return null;
        }

        $email = $site->getConfiguration()['llmsTxtContactEmail'] ?? '';
        return !empty($email) ? trim($email) : null;
    }

    /**
     * Get keywords/topics
     */
    public function getKeywords(): array
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return [];
        }

        $keywords = $site->getConfiguration()['llmsTxtKeywords'] ?? '';
        if (empty($keywords)) {
            return [];
        }

        return array_map('trim', explode(',', $keywords));
    }

    /**
     * Get maximum navigation depth
     */
    public function getMaxDepth(): int
    {
        $site = $this->getCurrentSite();
        if ($site === null) {
            return 2;
        }

        return (int)($site->getConfiguration()['llmsTxtMaxDepth'] ?? 2);
    }
}
