<?php

namespace NITSAN\NsNewsSlider\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/***
 *
 * This file is part of the "[NITSAN]  News Slider" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 Sanjay Chauhan <sanjay@nitsan.in>, NITSAN Technologies Pvt.Ltd
 *
 ***/

/**
 * The repository for NewsSliders
 */
class NewsSliderRepository extends Repository
{
    /**
     * @var  array<non-empty-string, 'ASC'|'DESC'>
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING
    ];
}
