<?php

declare(strict_types=1);

namespace FGTCLB\LlmsTxt\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\FrontendRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Repository for fetching page data
 * Handles all database queries related to pages using the Repository pattern
 */
class PageRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool
    ) {}

    public function findById(int $pageId): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll()
            ->add(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));

        $result = $queryBuilder
            ->select('uid', 'title', 'subtitle', 'description', 'abstract')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($pageId))
            )
            ->executeQuery();

        return $result->fetchAssociative() ?: [];
    }

    public function findNavigationByParent(int $parentUid): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll()
            ->add(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));

        $result = $queryBuilder
            ->select('uid', 'pid', 'title', 'description', 'abstract', 'nav_title', 'doktype')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($parentUid)),
                $queryBuilder->expr()->eq('nav_hide', $queryBuilder->createNamedParameter(0)),
                $queryBuilder->expr()->eq('no_index', $queryBuilder->createNamedParameter(0))
            )
            ->orderBy('sorting')
            ->executeQuery();

        $pages = [];
        while ($row = $result->fetchAssociative()) {
            $pages[] = [
                'uid' => $row['uid'],
                'pid' => $row['pid'],
                'title' => $row['nav_title'] ?: $row['title'],
                'description' => $row['description'],
                'abstract' => $row['abstract'],
                'doktype' => $row['doktype'],
            ];
        }

        return $pages;
    }

    public function findContentElementsByPage(int $pageId, int $maxResults = 20): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()
            ->add(GeneralUtility::makeInstance(FrontendRestrictionContainer::class));

        $result = $queryBuilder
            ->select('header', 'bodytext', 'CType')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pageId)),
            )
            ->orderBy('colPos, sorting')
            ->setMaxResults($maxResults)
            ->executeQuery();

        $elements = [];
        while ($row = $result->fetchAssociative()) {
            $elements[] = [
                'header' => $row['header'],
                'bodytext' => $row['bodytext'],
                'CType' => $row['CType'],
            ];
        }

        return $elements;
    }
}
