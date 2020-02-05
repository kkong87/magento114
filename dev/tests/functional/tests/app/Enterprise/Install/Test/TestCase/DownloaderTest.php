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

use Mage\Install\Test\Constraint\AssertWelcomeWizardTextPresent;
use Mage\Install\Test\Constraint\AssertSuccessDeploy;
use Mage\Install\Test\Page\DownloaderWelcome;
use Mage\Install\Test\Page\DownloaderValidation;
use Mage\Install\Test\Page\DownloaderDeploy;
use Enterprise\Install\Test\Page\DownloaderAuthorization;
use Mage\Install\Test\Page\DownloaderDeployEnd;
use Magento\Mtf\Fixture\FixtureFactory;
use Enterprise\Install\Test\Repository\DownloadConnect;


/**
 * PLEASE ADD NECESSARY INFO BEFORE RUNNING TEST TO ../dev/tests/functional/etc/config.xml
 *
 * Steps:
 * 1. Open downloader.php page.
 * 2. Download downloader files
 *
 * @group Installer_and_Upgrade/Downgrade_(PS)
 */
class DownloaderTest extends InstallTest
{
    /* tags */
    const TEST_TYPE = 'install';
    /* end tags */

    /**
     * Install page.
     *
     * @var DownloaderWelcome
     */
    protected $downloaderWelcome;

    /**
     * DownloaderValidation page.
     *
     * @var DownloaderValidation
     */
    protected $downloaderValidation;

    /**
     * DownloaderDeploy page.
     *
     * @var DownloaderDeploy
     */
    protected $downloaderDeploy;

    /**
     * Downloader authorization page.
     *
     * @var DownloaderAuthorization
     */
    protected  $downloaderAuthorization;

    /**
     * Downloader page.
     *
     * @var DownloaderDeployEnd
     */
    protected  $downloaderDeployEnd;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Fixture factory.
     *
     * @var AssertSuccessDeploy
     */
    protected $assertSuccessDeploy;

    /**
     * Injection data.
     *
     * @param DownloaderWelcome $downloaderWelcome
     * @param DownloaderValidation $downloaderValidation
     * @param DownloaderDeploy $downloaderDeploy
     * @param AssertSuccessDeploy $assertSuccessDeploy
     * @param DownloaderDeployEnd $downloaderDeployEnd
     * @param DownloaderAuthorization $downloaderAuthorization
     *  Downloader $downloaderDownloader,
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        DownloaderWelcome $downloaderWelcome,
        DownloaderValidation $downloaderValidation,
        DownloaderDeploy $downloaderDeploy,
        AssertSuccessDeploy $assertSuccessDeploy,
        DownloaderDeployEnd $downloaderDeployEnd,
        DownloaderAuthorization $downloaderAuthorization,
        FixtureFactory $fixtureFactory
    ) {
        $this->downloaderWelcome = $downloaderWelcome;
        $this->downloaderValidation = $downloaderValidation;
        $this->downloaderDeploy = $downloaderDeploy;
        $this->assertSuccessDeploy = $assertSuccessDeploy;
        $this->downloaderDeployEnd = $downloaderDeployEnd;
        $this->downloaderAuthorization = $downloaderAuthorization;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Install Magento via web interface.
     *
     * @param AssertWelcomeWizardTextPresent $assertWelcomeWizardTextPresent
     * @param DownloadConnect $downloadConnectData
     * @return array
     */
    public function test(AssertWelcomeWizardTextPresent $assertWelcomeWizardTextPresent, DownloadConnect $downloadConnectData)
    {
        //Preparation
        $downloadConnectFixture = $this->fixtureFactory->createByCode('downloadConnect',
            ['dataset' => 'enterpise_connect']);
        // Steps:
        $this->downloaderWelcome->open();
        // Verify license agreement.
        $assertWelcomeWizardTextPresent->processAssert($this->downloaderWelcome);
        $this->downloaderWelcome->getContinueDownloadBlock()->continueValidation();
        $this->downloaderValidation->getContinueDownloadBlock()->continueDeploy();
        $this->downloaderDeploy->getContinueDownloadBlock()->continueDeploy();

        $this->downloaderAuthorization->getChannelServerCredentials()->fill($downloadConnectFixture);
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
        $this->downloaderAuthorization->getChannelServerCredentials()->checkCredentials();
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
        $this->downloaderAuthorization->getAuthorizeMessages()->waitSuccessAuthorizeMessages();
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
        $this->downloaderAuthorization->getContinueAuthorization()->continueAuthorization();
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);

        $this->assertSuccessDeploy->processAssert($this->downloaderDeployEnd);
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);

        $this->downloaderDeploy->getContinueDownloadBlock()->continueDownload();
//        \Magento\Mtf\ObjectManager::getInstance()->create(\Magento\Mtf\System\Event\EventManagerInterface::class)->dispatchEvent(['exception']);
    }
}
