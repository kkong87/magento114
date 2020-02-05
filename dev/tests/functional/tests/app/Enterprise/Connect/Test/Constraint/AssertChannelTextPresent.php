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

namespace Enterprise\Connect\Test\Constraint;

use Mage\Connect\Test\Page\ConnectManager;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that magento connect has connected to according channel on the Magento Commerce side.
 */
class AssertChannelTextPresent extends AbstractConstraint
{
    /**
     * Title of channel
     */
    const CONNECT_CHANNEL_TEXT = 'Channel: Magento Enterprise Edition';

    /**
     * Verification of title
     *
     * @param ConnectManager $connectManager
     * @return void
     */
    public function processAssert(ConnectManager $connectManager)
    {
        \PHPUnit_Framework_Assert::assertContains(
            self::CONNECT_CHANNEL_TEXT,
            $connectManager->getConnectContent()->getChannelTitle(),
            'License agreement text is absent.'
        );
    }

    /**
     * Returns a string representation of successful assertion.
     *
     * @return string
     */
    public function toString()
    {
        return "Magento has connected to channel successfully";
    }
}
