.. include:: /Includes.rst.txt

=============
Configuration
=============

TypoScript Configuration
========================

The LLMS TXT Generator extension can be configured through TypoScript to customize its behavior and output.

Main Configuration
------------------

All configuration is done under the ``llmstxt`` TypoScript path:

.. code-block:: typoscript

   llmstxt {
       settings {
           # Enable/disable the extension
           enabled = 1

           # Maximum navigation depth to include
           maxDepth = 3

           # Custom site title (overrides page title)
           titleOverride =

           # Custom site description (overrides page description)
           descriptionOverride =

           # Keywords/topics for the site
           keywords = TYPO3, web development, content management

           # Contact email for AI systems
           contactEmail = contact@example.com

           # Additional information to append
           additionalInfo = This site uses TYPO3 CMS for content management.
       }
   }

Configuration Options
=====================

enabled
-------

:Default: ``1``
:Type: boolean
:Description: Enable or disable llms.txt generation. When disabled, the llms.txt endpoint returns a message indicating generation is disabled.

.. code-block:: typoscript

   llmstxt.settings.enabled = 0

maxDepth
--------

:Default: ``3``
:Type: integer
:Description: Maximum depth of navigation structure to include in the llms.txt file. Higher values include more levels of your site hierarchy.

.. code-block:: typoscript

   llmstxt.settings.maxDepth = 5

titleOverride
-------------

:Default: *(empty, uses root page title)*
:Type: string
:Description: Custom title to use instead of the site's root page title.

.. code-block:: typoscript

   llmstxt.settings.titleOverride = My Custom Site Title

descriptionOverride
-------------------

:Default: *(empty, uses root page description)*
:Type: string
:Description: Custom description to use instead of the site's root page description.

.. code-block:: typoscript

   llmstxt.settings.descriptionOverride = A comprehensive resource for web development and TYPO3 expertise.

keywords
--------

:Default: *(empty)*
:Type: comma-separated string
:Description: Keywords or topics that describe your site's content. These appear in the llms.txt file as topics.

.. code-block:: typoscript

   llmstxt.settings.keywords = TYPO3, PHP, web development, content management, documentation

contactEmail
------------

:Default: *(empty)*
:Type: string
:Description: Contact email address for AI systems or those with questions about your llms.txt implementation.

.. code-block:: typoscript

   llmstxt.settings.contactEmail = ai-contact@example.com

additionalInfo
--------------

:Default: *(empty)*
:Type: text
:Description: Additional information to include at the end of the llms.txt file. Can include multiple lines.

.. code-block:: typoscript

   llmstxt.settings.additionalInfo (
   This website contains educational content about TYPO3 CMS.

   For questions about content usage, please contact our editorial team.
   All content is available under Creative Commons licensing unless otherwise noted.
   )

Page Type Configuration
=======================

The extension defines two page types for serving content:

llms.txt Page Type
------------------

.. code-block:: typoscript

   llmstxt = PAGE
   llmstxt {
       typeNum = 1699

       config {
           disableAllHeaderCode = 1
           additionalHeaders.10.header = Content-Type: text/plain; charset=utf-8
           additionalHeaders.10.replace = 1
           xhtml_cleaning = 0
           admPanel = 0
           debug = 0
           no_cache = 1
       }

       10 = USER
       10 {
           userFunc = FGTCLB\LlmsTxt\Controller\LlmsTxtController->generateAction
       }
   }

Markdown Page Type
------------------

.. code-block:: typoscript

   markdown_page = PAGE
   markdown_page {
       typeNum = 1701

       config {
           disableAllHeaderCode = 1
           additionalHeaders.10.header = Content-Type: text/plain; charset=utf-8
           additionalHeaders.10.replace = 1
           xhtml_cleaning = 0
           admPanel = 0
           debug = 0
           no_cache = 1
           forceAbsoluteUrls = 1
       }

       10 = USER
       10 {
           userFunc = FGTCLB\LlmsTxt\Controller\LlmsTxtController->renderPageAsMarkdown
       }
   }

Route Configuration
===================

The extension includes route enhancers to create user-friendly URLs:

.. code-block:: yaml

   # EXT:llms_txt/Configuration/Routes/RouterEnhancer.yaml
   routeEnhancers:
     PageTypeSuffix:
       type: PageType
       map:
         .md: 1701
         llms.txt: 1699

To use these routes, include them in your site configuration:

.. code-block:: yaml

   # config/sites/main/config.yaml
   imports:
     -
       resource: 'EXT:llms_txt/Configuration/Routes/RouterEnhancer.yaml'

Advanced Configuration
======================

Custom Navigation Filtering
----------------------------

If you need to exclude certain pages from the llms.txt navigation structure, you can extend the NavigationBuilder service or use standard TYPO3 page properties:

* Set "Hide in navigation" to exclude pages from llms.txt
* Use "Access" settings to control visibility
* Set pages to hidden to exclude them entirely

Custom Content Processing
--------------------------

The extension uses TYPO3's standard content rendering. To customize how content appears in Markdown:

* Use standard TYPO3 content element configuration
* Customize TypoScript rendering for specific content types
* The extension respects all standard TYPO3 content visibility settings

Example Complete Configuration
==============================

.. code-block:: typoscript

   llmstxt {
       settings {
           enabled = 1
           maxDepth = 4
           titleOverride = ACME Corporation - Web Solutions
           descriptionOverride = Leading provider of TYPO3 development and consulting services
           keywords = TYPO3, web development, consulting, e-commerce, digital solutions
           contactEmail = partnerships@acme-corp.com
           additionalInfo (
   ACME Corporation specializes in TYPO3 CMS development and digital transformation.

   Our content is available for AI training and research purposes.
   Please respect our robots.txt guidelines for crawling frequency.

   For partnership inquiries, contact partnerships@acme-corp.com
           )
       }
   }
