<?php
namespace NITSAN\NsNewsSlider\Controller;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
 * NewsSliderController
 */
class NewsSliderController extends \GeorgRinger\News\Controller\NewsController
{
    /**
     * newsSliderRepository
     *
     * @var \NITSAN\NsNewsSlider\Domain\Repository\NewsSliderRepository
     * @inject
     */
    protected $newsSliderRepository = null;

    /**
     * @var \GeorgRinger\News\Domain\Repository\NewsRepository
     */
    protected $newsRepository;

    protected $sliderName;

    /**
     * Initializes the current action
     *
     */
    public function initializeAction()
    {
        $this->sliderName = $this->request->getControllerActionName();
        $tsSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            'ns_news_slider',
            'nsnewsslider_nsnewsslider'
        );

        // Set constant settings for the news
        if (is_array($tsSettings['settings'][$this->sliderName])) {
            foreach ($tsSettings['settings'][$this->sliderName] as $key=>$css) {
                if ( !$this->settings[$this->sliderName][$key] ) {
                    $this->settings[$this->sliderName][$key] = $css;
                }
            }
        }
    }

    /**
     * Function: nivoSlider
     * Output a flexslider view of news
     */
    public function nivoSliderAction()
    {
        $news = $this->findNews();

        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;

        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
    }

    /**
     * @return void string the Rendered view
     */
    public function owlcarouselSliderAction()
    {
        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();

        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
    }

    /**
     * @param array $overwriteDemand
     * @return return string the Rendered view
     */
    public function royalSliderAction()
    {
        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();

        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
    }

    /**
     * @param array $overwriteDemand
     * @return return string the Rendered view
     */
    public function slidejsSliderAction()
    {
        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();

        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
    }

/**
     * @param array $overwriteDemand
     * @return return string the Rendered view
     */
    public function slickSliderAction()
    {
        // Get settings.
        $settings = $this->settings;
        $settings['sliderType'] = $this->sliderName;
        $news = $this->findNews();

        $this->view->assignMultiple([
            'news' => $news,
            'settings' => $settings
        ]);
    }

    /**
     * @param array $overwriteDemand
     * @return void string the Rendered view
     */
    public function findNews(array $overwriteDemand = NULL)
    {

        $demand = parent::createDemandObjectFromSettings($this->settings);

        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
            $demand = parent::overwriteDemandObject($demand, $overwriteDemand);
        }

        $news = $this->newsRepository->findDemanded($demand);

        if (!count($news)){

            $this->addFlashMessage(
                LocalizationUtility::translate('fe.nonews', 'ns_news_slider'),
                LocalizationUtility::translate('fe.nonewsTitle', 'ns_news_slider'),
                \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING
            );
        }
        return $news;
    }
}