# LLMS TXT Generator for TYPO3

[![TYPO3 13](https://img.shields.io/badge/TYPO3-13-orange.svg)](https://get.typo3.org/version/13)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://www.php.net/)
[![License: GPL v2+](https://img.shields.io/badge/License-GPL%20v2+-blue.svg)](https://www.gnu.org/licenses/gpl-2.0)

TYPO3 extension for generating `.well-known/llm.txt` files according to the [llmstxt.org specification](https://llmstxt.org/) to control Large Language Model crawling policies.

## Features

- **Automatic llms.txt generation** - Creates policy files according to the official specification
- **Site navigation structure** - Includes your site's navigation hierarchy in the llms.txt file
- **Configurable metadata** - Add topics, contact information, and custom descriptions
- **Markdown export** - Convert any TYPO3 page to Markdown format via `.md` suffix
- **TYPO3 v13 compatibility** - Built specifically for TYPO3 v13 using modern PHP practices
- **Flexible configuration** - Control depth, content, and behavior through TypoScript

## What is llms.txt?

llms.txt is an emerging standard for websites to communicate with Large Language Models and AI systems. Similar to robots.txt for web crawlers, llms.txt files provide:

- **Crawling policies** - Guidelines for AI systems on how to interact with your content
- **Site structure** - Navigation and content organization information
- **Metadata** - Topics, contact information, and site descriptions
- **Content access** - Direct links to machine-readable content formats

## Installation

### Composer (Recommended)

```bash
composer require fgtclb/llms-txt
```

### Extension Manager

1. Go to **Admin Tools > Extensions** in the TYPO3 backend
2. Search for "llms_txt" in the **Get Extensions** section
3. Install and activate the extension

## Quick Start

After installation, the extension works immediately with default settings:

- **llms.txt file**: Visit `https://yoursite.com/.well-known/llm.txt`
- **Markdown pages**: Add `.md` to any page URL (e.g., `https://yoursite.com/about.md`)

## Configuration

Configure the extension through TypoScript:

```typoscript
llmstxt {
    settings {
        # Enable/disable the extension
        enabled = 1

        # Maximum navigation depth
        maxDepth = 3

        # Custom site title and description
        titleOverride = My Custom Site Title
        descriptionOverride = A comprehensive resource for web development

        # Keywords/topics for the site
        keywords = TYPO3, web development, content management

        # Contact email for AI systems
        contactEmail = ai-contact@example.com

        # Additional information
        additionalInfo = This site uses TYPO3 CMS for content management.
    }
}
```

## Route Configuration

To enable user-friendly URLs, include the route enhancers in your site configuration:

```yaml
# config/sites/main/config.yaml
imports:
  -
    resource: 'EXT:llms_txt/Configuration/Routes/RouterEnhancer.yaml'
```

This enables:
- `.md` suffix for Markdown content
- `llms.txt` for direct access to the specification file

## Usage Examples

### Accessing Generated Content

**llms.txt files:**
- `https://yoursite.com/.well-known/llm.txt` - Main specification file
- `https://yoursite.com/llms.txt` - Alternative access (with route enhancer)

**Markdown content:**
- `https://yoursite.com/about.md` - Markdown version of your About page
- `https://yoursite.com/services/consulting.md` - Markdown version of any page

### Sample llms.txt Output

```
ACME Corporation - Web Solutions
Leading provider of TYPO3 development and consulting services

**Topics:** TYPO3, web development, consulting, e-commerce
**Contact:** partnerships@acme-corp.com

## Navigation

- [Home](https://example.com/)
- [About Us](https://example.com/about)
  - [Our Team](https://example.com/about/team)
  - [History](https://example.com/about/history)
- [Services](https://example.com/services)
  - [TYPO3 Development](https://example.com/services/typo3)
  - [Consulting](https://example.com/services/consulting)
- [Contact](https://example.com/contact)

---

This site uses TYPO3 CMS for content management.
For partnership inquiries, contact partnerships@acme-corp.com
```

## Requirements

- **TYPO3**: 13.0 or higher
- **PHP**: 8.3 or higher
- **Dependencies**: league/html-to-markdown (automatically installed)

## Documentation

Comprehensive documentation is available covering:

- [Installation and Configuration](Documentation/Administrator/Index.rst)
- [Editor Guidelines](Documentation/Editor/Index.rst)
- [Developer API Reference](Documentation/Developer/Index.rst)
- [TypoScript Configuration](Documentation/Configuration/Index.rst)

## Architecture

The extension follows modern TYPO3 v13 development practices:

- **Service-oriented architecture** with dependency injection
- **Clean separation of concerns** with dedicated services
- **Type-safe PHP 8.3+** with strict typing throughout
- **PSR-12 compliant** code standards
- **Comprehensive testing** foundation

### Core Services

- **LlmsTxtGeneratorService** - Orchestrates llms.txt generation
- **MarkdownConverterService** - Converts HTML to Markdown
- **ConfigurationService** - Handles TypoScript configuration
- **NavigationBuilder** - Builds site navigation structures
- **PageRepository** - Database access with TYPO3 context awareness

## Contributing

Contributions are welcome! Please:

1. Follow TYPO3 coding standards
2. Include tests for new features
3. Update documentation for configuration changes
4. Use dependency injection patterns
5. Maintain strict typing

## License

This extension is licensed under GPL v2+ - see the [LICENSE](LICENSE) file for details.

## Support

- **Documentation**: Full documentation in the `Documentation/` folder
- **Issues**: Report issues via the project issue tracker
- **Community**: Join TYPO3 community discussions for general TYPO3 support

## Related

- [llmstxt.org](https://llmstxt.org/) - Official specification
- [TYPO3 Documentation](https://docs.typo3.org/) - TYPO3 CMS documentation
- [Academic Extensions](https://github.com/fgtclb/academic-extensions) - Related TYPO3 extensions by FGTCLB
