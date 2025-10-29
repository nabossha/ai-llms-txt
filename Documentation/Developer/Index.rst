.. include:: /Includes.rst.txt

=========
Developer
=========

Architecture Overview
======================

The LLMS TXT Generator extension follows modern TYPO3 v13 development practices with a clean, service-oriented architecture.

Core Components
===============

Services
--------

**ConfigurationService**
  Handles all TypoScript configuration reading and provides typed access to configuration values.

**LlmsTxtGeneratorService**
  Main application service that orchestrates the generation of llms.txt content by coordinating other services.

**MarkdownConverterService**
  Converts HTML content to Markdown format using the league/html-to-markdown library.

**NavigationBuilder**
  Builds the site navigation structure for inclusion in llms.txt files.

Repository
----------

**PageRepository**
  Provides database access for page records with proper respect for TYPO3's language and workspace handling.

Controller
----------

**LlmsTxtController**
  Thin controller layer that handles HTTP requests and delegates business logic to services. Provides entry points for TypoScript USER objects.

API Reference
=============

Controller Methods
------------------

FGTCLB\\LlmsTxt\\Controller\\LlmsTxtController
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. php:method:: generateAction(string $content = '', array $conf = []): string

   Generates llms.txt content for TypoScript USER object.

   :param string $content: Content passed from TypoScript (usually empty)
   :param array $conf: Configuration array from TypoScript
   :returns: Generated llms.txt content as string
   :throws: Exception on generation failures

.. php:method:: renderPageAsMarkdown(string $content = '', array $conf = []): string

   Renders current page as Markdown by leveraging TYPO3's frontend rendering.

   :param string $content: Content passed from TypoScript (usually empty)
   :param array $conf: Configuration array from TypoScript
   :returns: Page content converted to Markdown format
   :throws: Exception on rendering or conversion failures

Service Classes
---------------

FGTCLB\\LlmsTxt\\Service\\LlmsTxtGeneratorService
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. php:method:: generateLlmsTxt(int $currentPageId): string

   Generates complete llms.txt content for a given page context.

   :param int $currentPageId: Current page ID for context
   :returns: Complete llms.txt formatted content

FGTCLB\\LlmsTxt\\Service\\ConfigurationService
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. php:method:: isEnabled(): bool

   Checks if llms.txt generation is enabled.

   :returns: True if enabled, false otherwise

.. php:method:: getMaxDepth(): int

   Gets maximum navigation depth setting.

   :returns: Maximum depth as integer

.. php:method:: getTitleOverride(): string

   Gets custom title override if configured.

   :returns: Custom title or empty string

.. php:method:: getDescriptionOverride(): string

   Gets custom description override if configured.

   :returns: Custom description or empty string

.. php:method:: getKeywords(): array

   Gets configured keywords/topics.

   :returns: Array of keyword strings

.. php:method:: getContactEmail(): string

   Gets configured contact email.

   :returns: Contact email or empty string

.. php:method:: getAdditionalInfo(): string

   Gets additional information text.

   :returns: Additional info or empty string

.. php:method:: getSiteUrl(): string

   Gets the current site's base URL.

   :returns: Site URL as string

Extending the Extension
=======================

Adding Custom Content Processors
---------------------------------

To customize how content is processed for Markdown conversion, you can extend or override the MarkdownConverterService:

.. code-block:: php

   <?php
   declare(strict_types=1);

   namespace Vendor\MyExtension\Service;

   use FGTCLB\LlmsTxt\Service\MarkdownConverterService;

   class CustomMarkdownConverterService extends MarkdownConverterService
   {
       public function convertHtmlToMarkdown(string $html): string
       {
           // Custom preprocessing
           $html = $this->preprocessHtml($html);

           // Call parent conversion
           $markdown = parent::convertHtmlToMarkdown($html);

           // Custom postprocessing
           return $this->postprocessMarkdown($markdown);
       }

       protected function preprocessHtml(string $html): string
       {
           // Add custom HTML preprocessing logic
           return $html;
       }

       protected function postprocessMarkdown(string $markdown): string
       {
           // Add custom Markdown postprocessing logic
           return $markdown;
       }
   }

Register your custom service in Services.yaml:

.. code-block:: yaml

   services:
     Vendor\MyExtension\Service\CustomMarkdownConverterService:
       public: true
       autowire: true
       autoconfigure: true

     # Override the original service
     FGTCLB\LlmsTxt\Service\MarkdownConverterService:
       alias: 'Vendor\MyExtension\Service\CustomMarkdownConverterService'

Custom Navigation Building
---------------------------

To customize navigation structure generation:

.. code-block:: php

   <?php
   declare(strict_types=1);

   namespace Vendor\MyExtension\Builder;

   use FGTCLB\LlmsTxt\Builder\NavigationBuilder;

   class CustomNavigationBuilder extends NavigationBuilder
   {
       public function build(int $rootPageId, int $maxDepth): array
       {
           $navigation = parent::build($rootPageId, $maxDepth);

           // Add custom navigation processing
           return $this->filterCustomNavigation($navigation);
       }

       protected function filterCustomNavigation(array $navigation): array
       {
           // Implement custom filtering logic
           return $navigation;
       }
   }

Custom Configuration Sources
----------------------------

To add configuration from other sources (database, external APIs, etc.):

.. code-block:: php

   <?php
   declare(strict_types=1);

   namespace Vendor\MyExtension\Service;

   use FGTCLB\LlmsTxt\Service\ConfigurationService;

   class CustomConfigurationService extends ConfigurationService
   {
       public function getKeywords(): array
       {
           // Get keywords from parent (TypoScript)
           $keywords = parent::getKeywords();

           // Add keywords from custom source
           $customKeywords = $this->getKeywordsFromDatabase();

           return array_merge($keywords, $customKeywords);
       }

       protected function getKeywordsFromDatabase(): array
       {
           // Implement database keyword retrieval
           return [];
       }
   }

Hooks and Events
================

The extension doesn't currently provide PSR-14 events, but you can extend functionality through:

1. **Service replacement** - Override services through dependency injection
2. **TypoScript configuration** - Extend configuration options
3. **Custom page types** - Create additional page types using the same controller methods

Testing
=======

Unit Testing
------------

The extension includes PHPUnit tests. To run tests:

.. code-block:: bash

   # Run all tests
   vendor/bin/phpunit -c packages/llms_txt/Tests/

   # Run specific test suite
   vendor/bin/phpunit -c packages/llms_txt/Tests/Unit/

Functional Testing
------------------

For functional testing, ensure your test setup includes:

* Proper site configuration
* Test page tree structure
* Content elements for testing

.. code-block:: php

   <?php
   declare(strict_types=1);

   namespace FGTCLB\LlmsTxt\Tests\Functional;

   use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

   class LlmsTxtGenerationTest extends FunctionalTestCase
   {
       protected array $testExtensionsToLoad = [
           'typo3conf/ext/llms_txt',
       ];

       public function testLlmsTxtGeneration(): void
       {
           // Test llms.txt generation logic
       }
   }

Performance Considerations
==========================

**Navigation Building**
  Navigation structure generation scales with site size. For large sites (1000+ pages), consider:

  * Reducing maxDepth setting
  * Implementing custom navigation filtering
  * Adding caching layers

**Content Rendering**
  Markdown conversion processes all content elements. For content-heavy pages:

  * Consider selective content rendering
  * Implement content type filtering
  * Use caching for expensive conversions

**Memory Usage**
  The HTML-to-Markdown conversion can be memory-intensive for large pages. Monitor memory usage and consider:

  * Chunked processing for very large pages
  * Custom memory-efficient conversion strategies

Contributing
============

When contributing to the extension:

1. **Follow TYPO3 coding standards** - Use php-cs-fixer with TYPO3 ruleset
2. **Write tests** - Include unit and functional tests for new features
3. **Document changes** - Update documentation for new configuration options
4. **Use dependency injection** - Prefer constructor injection over service location
5. **Type everything** - Use strict types and comprehensive type hints
