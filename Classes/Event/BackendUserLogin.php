<?php

declare(strict_types=1);

namespace NITSAN\NsNewsSlider\Event;

use NITSAN\NsLicense\Service\LicenseService;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent;

class BackendUserLogin
{
    /**
     * @param AfterUserLoggedInEvent $backendUser
     * @return void
     */
    public function dispatch(AfterUserLoggedInEvent $backendUser): void
    {
        if ($backendUser->getUser() instanceof BackendUserAuthentication) {
            // Let's check license system
            $isLicenseActivate = GeneralUtility::makeInstance(PackageManager::class)->isPackageActive('ns_license');
            if ($isLicenseActivate) {
                $nsLicenseModule = GeneralUtility::makeInstance(LicenseService::class);

                $nsLicenseModule->connectToServer('ns_news_slider', 0);
            }
        }
    }
}
