<?php

declare(strict_types=1);

namespace FGTCLB\LlmsTxt\Controller;

use FGTCLB\LlmsTxt\Repository\PageRepository;
use FGTCLB\LlmsTxt\Service\ConfigurationService;
use FGTCLB\LlmsTxt\Service\LlmsTxtGeneratorService;
use FGTCLB\LlmsTxt\Service\MarkdownConverterService;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Controller for serving llms.txt content via TypoScript PAGE object
 *
 * This controller is kept thin - it only handles HTTP request/response
 * and delegates all business logic to dedicated service classes.
 */
class LlmsTxtController
{
    public function __construct(
        private readonly LlmsTxtGeneratorService $llmsTxtGenerator,
        private readonly ConfigurationService $configurationService,
        private readonly MarkdownConverterService $markdownConverter,
        private readonly PageRepository $pageRepository,
        private readonly Context $context
    ) {}

    /**
     * Generate llms.txt content for TypoScript USER object
     */
    public function generateAction(string $content = '', array $conf = []): string
    {
        try {
            $currentPageId = $this->getCurrentPageId();
            return $this->llmsTxtGenerator->generateLlmsTxt($currentPageId);
        } catch (\Exception $e) {
            // Return error message in llms.txt format
            return "llmstxt: 1.0\nsite: " . $this->configurationService->getSiteUrl() . "\nerror: Failed to generate content\n";
        }
    }

    /**
     * Render current page as Markdown by leveraging TYPO3's frontend rendering
     * This approach uses TYPO3's normal rendering pipeline to get ALL content
     * from all column positions (colPos 0, 1, 100+)
     */
    public function renderPageAsMarkdown(string $content = '', array $conf = []): string
    {
        try {
            $pageHtml = $this->getRenderedPageContent();

            if (empty($pageHtml)) {
                return "# Error\n\nNo page content could be rendered.\n";
            }

            $markdown = $this->markdownConverter->convertHtmlToMarkdown($pageHtml);

            if (empty(trim($markdown))) {
                return "# Error\n\nPage rendered but conversion to Markdown failed.\n";
            }

            return $markdown;

        } catch (\Exception $e) {
            return "# Error\n\nFailed to render page: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Get the fully rendered page content from TYPO3's frontend rendering
     * This captures ALL content elements from all column positions
     */
    protected function getRenderedPageContent(): string
    {
        if (!isset($GLOBALS['TSFE']) || !($GLOBALS['TSFE'] instanceof TypoScriptFrontendController)) {
            throw new \RuntimeException('TSFE not available');
        }

        $cObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $cObject->start([], 'pages');

        $pageId = $this->getCurrentPageId();
        $page = $this->pageRepository->findById($pageId);

        $html = "<!-- Auto-generated content -->\n";

        if (!empty($page['title'])) {
            $html .= '<h1>' . htmlspecialchars($page['title']) . '</h1>';
        }

        if (!empty($page['description'])) {
            $html .= '<p class="page-description"> > ' . htmlspecialchars($page['description']) . '</p>';
        }

        // Render ALL content elements from ALL column positions
        // This ensures we capture everything on the page even third-party extensions
        $contentConfiguration = [
            'table' => 'tt_content',
            'select.' => [
                'orderBy' => 'colPos, sorting',
                'where' => '{#deleted}=0 AND {#hidden}=0',
                'pidInList' => (string)$pageId,
            ],
        ];
        $renderedContent = $cObject->cObjGetSingle('CONTENT', $contentConfiguration);


        if (!empty($renderedContent)) {
            $html .= $renderedContent;
        }

        return $html;
    }

    /**
     * Get current page ID from TYPO3 context
     */
    protected function getCurrentPageId(): int
    {
        try {
            $pageAspect = $this->context->getAspect('page');
            return (int)$pageAspect->get('id');
        } catch (\Exception $e) {
            if (isset($GLOBALS['TSFE']) && $GLOBALS['TSFE'] instanceof TypoScriptFrontendController) {
                return (int)$GLOBALS['TSFE']->id;
            }
        }

        return 0;
    }
}
