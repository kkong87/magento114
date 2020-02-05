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

namespace Enterprise\Install\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Element\SimpleElement as Element;
use Magento\Mtf\Client\Locator;

/**
 * Global messages block.
 */
class AuthorizeMessages extends Block
{
    /**
     * Success message selector.
     *
     * @var string
     */
    protected $successAuthorizeMessages = '.msg_success li';

    /**
     * Error message.
     *
     * @var string
     */
    protected $errorAuthorizeMessages = '.msg_error li';

    /**
     * Wait for success message.
     *
     * @return bool
     */
    public function waitSuccessAuthorizeMessages()
    {
        return $this->waitForElementVisible($this->successAuthorizeMessages);
    }

    /**
     * Wait for error message.
     *
     * @return bool
     */
    public function waitErrorAuthorizeMessages()
    {
        return $this->waitForElementVisible($this->errorAuthorizeMessages);
    }
}
