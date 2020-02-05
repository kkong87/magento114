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

namespace Enterprise\Install\Test\Page;

use Magento\Mtf\Page\FrontendPage;

/**
 * Class Downloader
 */
class Downloader extends FrontendPage
{
    const MCA = 'downloader/';

    /**
     * Blocks' config
     *
     * @var array
     */
    protected $blocks = [
        'channelServerCredentials' => [
            'class' => 'Enterprise\Install\Test\Block\ChannelServerCredentials',
            'locator' => '#install_all',
            'strategy' => 'css selector',
        ],
        'continueDownloadBlock' => [
            'class' => 'Mage\Install\Test\Block\ContinueDownloadBlock',
            'locator' => '#main',
            'strategy' => 'css selector',
        ],
        'messagesBlock' => [
            'class' => 'Mage\Core\Test\Block\Messages',
            'locator' => '#connect_iframe_success .msgs',
            'strategy' => 'css selector',
        ],
    ];

    /**
     * @return \Enterprise\Install\Test\Block\ChannelServerCredentials
     */
    public function getChannelServerCredentials()
    {
        return $this->getBlockInstance('channelServerCredentials');
    }

    /**
     * @return \Mage\Install\Test\Block\ContinueDownloadBlock
     */
    public function getContinueDownloadBlock()
    {
        return $this->getBlockInstance('continueDownloadBlock');
    }

    /**
     * @return \Mage\Core\Test\Block\Messages
     */
    public function getMessagesBlock()
    {
        return $this->getBlockInstance('messagesBlock');
    }
}
