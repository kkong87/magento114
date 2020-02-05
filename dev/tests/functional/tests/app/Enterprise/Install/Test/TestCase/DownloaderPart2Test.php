<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Tests
 * @package     Tests_Functional
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

namespace Enterprise\Install\Test\TestCase;

use Enterprise\Install\Test\Page\Downloader;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * PLEASE ADD NECESSARY INFO BEFORE RUNNING TEST TO ../dev/tests/functional/etc/config.xml
 *
 * Preconditions:
 * 1. Uninstall Magento.
 *
 * Steps:
 * 1. Opens Magento download page.
 * 2. Downloads magento
 * 3. Opens Magento Installation page
 *
 * @group Installer_and_Upgrade/Downgrade_(PS)
 */
class DownloaderPart2Test extends InstallTest
{
    /* tags */
    const TEST_TYPE = 'install';
    /* end tags */

    /**
     * Downloader page.
     *
     * @var Downloader
     */
    protected $downloaderDownloader;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Injection data.
     *
     * @param Downloader $downloaderDownloader
     */
    public function __inject(Downloader $downloaderDownloader)
    {
        $this->downloaderDownloader = $downloaderDownloader;
    }

    /**
     * Install Magento via web interface.
     *
     * @param array $configData
     * @return array
     */
    public function test($configData)
    {
        //Preparation
        $downloadConnectFixture = $this->fixtureFactory->createByCode('downloadConnect',
            ['dataset' => 'enterpise_connect']);
        // Steps:
        $this->downloaderDownloader->open();
        // File credentials
        $this->downloaderDownloader->getChannelServerCredentials()->fill($downloadConnectFixture);
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);

        // Start downloading
        $this->downloaderDownloader->getContinueDownloadBlock()->startDownload();
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
        $i = 1;
        while ($i <= 15 and (!(($this->downloaderDownloader->getMessagesBlock()->isVisibleMessage('success')) or
            ($this->downloaderDownloader->getMessagesBlock()->isVisibleMessage('error'))))
        ) {
            sleep(60);
            $i++;
//            \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
        }

        $this->downloaderDownloader->getMessagesBlock()->getSuccessMessages();
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
        $this->downloaderDownloader->getContinueDownloadBlock()->continueMagentoInstallation();
    }
}
