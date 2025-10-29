.. include:: /Includes.rst.txt

=========
Developer
=========

Architecture Overview
======================

The LLMS TXT Generator extension follows modern TYPO3 v13 development practices.

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

WebVision\\LlmsTxt\\Controller\\LlmsTxtController
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

WebVision\\LlmsTxt\\Service\\LlmsTxtGeneratorService
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. php:method:: generateLlmsTxt(int $currentPageId): string

   Generates complete llms.txt content for a given page context.

   :param int $currentPageId: Current page ID for context
   :returns: Complete llms.txt formatted content

WebVision\\LlmsTxt\\Service\\ConfigurationService
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

tbd.

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

tbd.

Functional Testing
------------------

tbd.

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
