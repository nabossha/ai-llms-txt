.. include:: /Includes.rst.txt

=========
ChangeLog
=========

Version 1.0.0
==============

Release Date: 2024-10-24

Initial Release
---------------

This is the initial release of the LLMS TXT Generator extension for TYPO3 v13.

New Features
~~~~~~~~~~~~

**Core Functionality**

* Complete llms.txt generation according to the llmstxt.org specification
* Automatic site navigation structure inclusion with configurable depth
* Page-to-Markdown conversion for any TYPO3 page via .md suffix
* Integration with TYPO3's native content rendering pipeline

**Configuration Options**

* TypoScript-based configuration for all settings
* Configurable navigation depth (maxDepth setting)
* Custom title and description overrides
* Keywords/topics configuration for site metadata
* Contact email specification for AI systems
* Additional information text support

**Technical Implementation**

* Built specifically for TYPO3 v13 using modern PHP 8.3+ practices
* Service-oriented architecture with dependency injection
* Proper separation of concerns with dedicated services for each responsibility
* HTML-to-Markdown conversion using league/html-to-markdown library
* Route enhancers for user-friendly URLs (.md suffix and llms.txt endpoints)

**Developer Features**

* Comprehensive API with proper type hints and documentation
* Extensible service architecture for customization
* Unit and functional test foundation
* PSR-12 compliant code with strict typing
* Composer package with proper autoloading

**Documentation**

* Complete documentation following TYPO3 standards
* Administrator installation and configuration guide
* Editor usage guidelines
* Developer API reference and extension guide
* Configuration examples and best practices

System Requirements
~~~~~~~~~~~~~~~~~~~

* TYPO3 CMS 13.0 or higher
* PHP 8.3 or higher
* league/html-to-markdown ^5.1 (automatically installed via Composer)

Breaking Changes
~~~~~~~~~~~~~~~~

This is the initial release, so no breaking changes apply.

Known Issues
~~~~~~~~~~~~

* Large sites (1000+ pages) may experience performance impacts during navigation generation
* Complex HTML structures may not convert perfectly to Markdown format
* Some web servers may require configuration for .well-known directory access

Migration Notes
~~~~~~~~~~~~~~~

This is a new extension, so no migration is required.

Deprecations
~~~~~~~~~~~~

No deprecations in this initial release.

Credits
~~~~~~~

* Development: FGTCLB
* Based on the llmstxt.org specification for AI-readable content guidelines
* Uses league/html-to-markdown for HTML-to-Markdown conversion

Installation
~~~~~~~~~~~~

Install via Composer:

.. code-block:: bash

   composer require fgtclb/llms-txt

Or install through the TYPO3 Extension Manager by searching for "llms_txt".

After installation, the extension is ready to use with default settings. Visit ``/.well-known/llm.txt`` to see the generated content.

For detailed configuration options, see the Configuration section of this documentation.
