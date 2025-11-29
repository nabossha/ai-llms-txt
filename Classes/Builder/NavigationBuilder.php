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
     * @param int[] $excludeDoktypes Optional array of doktypes to exclude from output (if empty, uses site configuration)
     * @return array Navigation structure
     */
    public function build(int $rootPageUid, int $maxDepth = 2, array $excludeDoktypes = []): array
    {
        $structure = [];

        // Use provided excludeDoktypes or fall back to site configuration
        if (empty($excludeDoktypes)) {
            $excludeDoktypes = $this->configurationService->getExcludeDoktypes();
        }

        // Get main navigation pages (level 1) - fetch ALL pages, filter output later
        $mainPages = $this->pageRepository->findNavigationByParent($rootPageUid);

        foreach ($mainPages as $mainPage) {
            // Check if this page's doktype should be excluded from output
            $isExcluded = in_array($mainPage['doktype'], $excludeDoktypes, true);

            // Collect subpages (always traverse, even into excluded pages)
            $subPagesOutput = [];
            if ($maxDepth >= 2) {
                $subPages = $this->pageRepository->findNavigationByParent($mainPage['uid']);

                foreach ($subPages as $subPage) {
                    // Only add subpage to output if not excluded
                    if (!in_array($subPage['doktype'], $excludeDoktypes, true)) {
                        $subPagesOutput[] = [
                            'uid' => $subPage['uid'],
                            'title' => $subPage['title'],
                            'url' => $this->urlGenerator->generatePageUrl($subPage['uid']),
                            'description' => $subPage['description'] ?: $subPage['abstract'] ?: '',
                        ];
                    }
                }
            }

            // If this page is excluded, promote its children to the current level
            if ($isExcluded) {
                foreach ($subPagesOutput as $promotedPage) {
                    $structure[] = [
                        'title' => $promotedPage['title'],
                        'description' => $promotedPage['description'],
                        'url' => $promotedPage['url'],
                        'pages' => [],
                    ];
                }
            } else {
                // Include this page normally with its subpages
                $structure[] = [
                    'title' => $mainPage['title'],
                    'description' => $mainPage['description'] ?: $mainPage['abstract'] ?: '',
                    'url' => $this->urlGenerator->generatePageUrl($mainPage['uid']),
                    'pages' => $subPagesOutput,
                ];
            }
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
