<?php

namespace NITSAN\NsNewsSlider\Controller;

use GeorgRinger\News\Controller\NewsController;
use TYPO3\CMS\Core\Resource\Exception\InvalidFileException;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class SliderBaseController extends NewsController
{
    /**
     * @param array|null $overwriteDemand
     * @return QueryResultInterface|array
     */
    public function findNews(?array $overwriteDemand = null): QueryResultInterface|array
    {
        $demand = parent::createDemandObjectFromSettings($this->settings);
        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== null) {
            $demand = parent::overwriteDemandObject($demand, $overwriteDemand);
        }
        $news = $this->newsRepository->findDemanded($demand);
        if (!count($news)) {
            $this->addFlashMessage(
                LocalizationUtility::translate('fe.nonews', 'ns_news_slider'),
                LocalizationUtility::translate('fe.nonewsTitle', 'ns_news_slider'),
                ContextualFeedbackSeverity::WARNING
            );
        }
        return $news;
    }

    /**
     * getPath for composer-based setup
     * @param mixed $path
     * @param mixed $extName
     * @return string
     * @throws InvalidFileException
     */
    public function getPath(mixed $path, mixed $extName): string
    {
        $arguments = ['path' => $path, 'extensionName' => $extName];
        $path = $arguments['path'];
        $publicPath = sprintf('EXT:%s/Resources/Public/%s', $arguments['extensionName'], ltrim($path, '/'));
        // @extensionScannerIgnoreLine
        $uri = PathUtility::getPublicResourceWebPath($publicPath);
        return substr($uri, 1);
    }
}
