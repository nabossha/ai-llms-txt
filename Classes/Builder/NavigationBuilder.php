<?php

declare(strict_types=1);

namespace WebVision\AiLlmsTxt\Builder;

use WebVision\AiLlmsTxt\Repository\PageRepository;
use WebVision\AiLlmsTxt\Service\ConfigurationService;
use WebVision\AiLlmsTxt\Service\UrlGeneratorService;

/**
 * Builder for creating hierarchical navigation structures
 * Uses the Builder pattern to construct complex navigation data
 */
class NavigationBuilder
{
    public function __construct(
        private readonly PageRepository $pageRepository,
        private readonly UrlGeneratorService $urlGenerator,
        private readonly ConfigurationService $configurationService
    ) {}

    /**
     * Build hierarchical navigation structure
     *
     * @param int $rootPageUid The root page UID
     * @param int $maxDepth Maximum navigation depth
     * @param int[] $excludeDoktypes Optional array of doktypes to exclude (if empty, uses site configuration)
     * @return array Navigation structure
     */
    public function build(int $rootPageUid, int $maxDepth = 2, array $excludeDoktypes = []): array
    {
        $structure = [];

        // Use provided excludeDoktypes or fall back to site configuration
        if (empty($excludeDoktypes)) {
            $excludeDoktypes = $this->configurationService->getExcludeDoktypes();
        }

        // Get main navigation pages (level 1)
        $mainPages = $this->pageRepository->findNavigationByParent($rootPageUid, $excludeDoktypes);

        foreach ($mainPages as $mainPage) {
            $section = [
                'title' => $mainPage['title'],
                'description' => $mainPage['description'] ?: $mainPage['abstract'] ?: '',
                'url' => $this->urlGenerator->generatePageUrl($mainPage['uid']),
                'pages' => [],
            ];

            // Get subpages if depth allows
            if ($maxDepth >= 2) {
                $subPages = $this->pageRepository->findNavigationByParent($mainPage['uid'], $excludeDoktypes);

                foreach ($subPages as $subPage) {
                    $section['pages'][] = [
                        'uid' => $subPage['uid'],
                        'title' => $subPage['title'],
                        'url' => $this->urlGenerator->generatePageUrl($subPage['uid']),
                        'description' => $subPage['description'] ?: $subPage['abstract'] ?: '',
                    ];
                }
            }

            $structure[] = $section;
        }

        return $structure;
    }

    /**
     * Format navigation structure as markdown lines
     */
    public function formatAsMarkdown(array $navigationStructure): array
    {
        $lines = [];

        foreach ($navigationStructure as $section) {
            // Section header (plain text)
            if (!empty($section['url'])) {
                $lines[] = "+ [{$section['title']}]({$section['url']})";
            }

            foreach ($section['pages'] as $page) {
                if (!empty($page['description'])) {
                    $lines[] = "  - [{$page['title']}]({$page['url']}): {$page['description']}";
                } else {
                    $lines[] = "  - [{$page['title']}]({$page['url']})";
                }
            }

            $lines[] = ''; // Empty line between sections
        }

        return $lines;
    }
}
