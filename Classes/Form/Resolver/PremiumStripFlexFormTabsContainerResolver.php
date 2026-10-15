<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\Form\Resolver;

use NITSAN\NsNewsSlider\Form\Container\PremiumStripFlexFormTabsContainer;
use TYPO3\CMS\Backend\Form\NodeFactory;
use TYPO3\CMS\Backend\Form\NodeResolverInterface;

/**
 * Uses PremiumStripFlexFormTabsContainer for the plugin options (pi_flexform) of the five news slider plugins.
 */
final class PremiumStripFlexFormTabsContainerResolver implements NodeResolverInterface
{
    private const PLUGIN_SIGNATURES = [
        'nsnewsslider_nivoslider',
        'nsnewsslider_owlcarouselslider',
        'nsnewsslider_royalslider',
        'nsnewsslider_sliderjsslider',
        'nsnewsslider_slickslider',
    ];

    private array $data;

    /**
     * TYPO3 v12 passes the node factory and data to the constructor, v13+ calls setData().
     */
    public function __construct(?NodeFactory $nodeFactory = null, array $data = [])
    {
        $this->data = $data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function resolve(): ?string
    {
        if (($this->data['tableName'] ?? '') !== 'tt_content'
            || ($this->data['fieldName'] ?? '') !== 'pi_flexform'
            || !empty($this->data['isInlineChild'])
        ) {
            return null;
        }

        $recordType = (string)($this->data['recordTypeValue'] ?? '');
        if (in_array($recordType, self::PLUGIN_SIGNATURES, true)) {
            return PremiumStripFlexFormTabsContainer::class;
        }

        $listType = $this->data['databaseRow']['list_type'] ?? '';
        if (is_array($listType)) {
            $listType = (string)($listType[0] ?? '');
        }

        return $recordType === 'list' && in_array($listType, self::PLUGIN_SIGNATURES, true)
            ? PremiumStripFlexFormTabsContainer::class
            : null;
    }
}
