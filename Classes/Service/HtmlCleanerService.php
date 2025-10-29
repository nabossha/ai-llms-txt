<?php

declare(strict_types=1);

namespace WebVision\AiLlmsTxt\Service;

/**
 * Service for cleaning TYPO3 HTML output
 * Removes framework-specific markup and presentational elements
 */
class HtmlCleanerService
{
    /**
     * Clean up TYPO3-specific HTML before conversion to Markdown
     *
     * Removes common TYPO3 wrapper elements and presentational markup
     * while preserving semantic HTML structure (headings, links, lists, paragraphs).
     */
    public function cleanTypo3Html(string $html): string
    {
        for ($i = 0; $i < 3; $i++) {
            $html = preg_replace('/<a[^>]*>\s*<\/a>/i', '', $html);
            $html = preg_replace('/<div[^>]*>\s*<\/div>/i', '', $html);
            $html = preg_replace('/<span[^>]*>\s*<\/span>/i', '', $html);
            $html = preg_replace('/<p[^>]*>[\s\r\n&nbsp;]*<\/p>/i', '', $html);
            $html = preg_replace('/<(section|article|aside)[^>]*>\s*<\/\1>/i', '', $html);
        }

        // Step 2: Normalize whitespace
        $html = preg_replace('/\s+/u', ' ', $html);
        $html = preg_replace('/>\s+</u', '><', $html);
        $html = preg_replace('/\s*(<\/?(?:h[1-6]|p|ul|ol|li|blockquote|pre|table|tr|td|th)(?:\s[^>]*)?>)\s*/i', '$1', $html);

        return trim($html);
    }
}
