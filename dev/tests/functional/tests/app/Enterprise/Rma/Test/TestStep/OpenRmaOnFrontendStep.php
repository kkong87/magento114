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

namespace Enterprise\Rma\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Mage\Sales\Test\Page\SalesGuestView;
use Mage\Cms\Test\Page\CmsIndex;
use Mage\Sales\Test\Page\OrderView;
use Mage\Customer\Test\TestStep\LoginCustomerOnFrontendStep;
use Mage\Sales\Test\TestStep\OpenSalesOrderOnFrontendForGuestStep;
use Magento\Mtf\ObjectManager;
use Mage\Customer\Test\Fixture\Customer;
use Mage\Sales\Test\Fixture\Order;

/**
 * Open RMA on frontend for customer or guest step.
 */
class OpenRmaOnFrontendStep implements TestStepInterface
{
    /**
     * Sales guest view page.
     *
     * @var SalesGuestView
     */
    protected $salesGuestView;

    /**
     * Checkout method for customer or guest
     *
     * @string
     */
    protected $checkoutMethod;

    /**
     * Cms index page
     *
     * @var CmsIndex
     */
    protected $cmsIndex;

    /**
     * Order view page
     *
     * @var OrderView
     */
    protected $orderView;

    /**
     * Step to login for customer on Front-end
     *
     * @var LoginCustomerOnFrontendStep
     */
    protected $loginCustomerOnFrontendStep;

    /**
     * Step to open order page for guest
     *
     * @var OpenSalesOrderOnFrontendForGuestStep
     */
    protected $openSalesOrderOnFrontendForGuestStep;

    /**
     * Object Manager
     *
     * @var \Magento\Mtf\ObjectManager
     */
    protected $objectManager;

    /**
     *  Customer fixture
     *
     * @var Customer
     */
    protected $customer;

    /**
     * Order fixture
     *
     * @var Order
     */
    protected $order;

    /**
     * @constructor
     * @param SalesGuestView $salesGuestView
     * @param $checkoutMethod
     * @param CmsIndex $cmsIndex
     * @param OrderView $orderView
     * @param LoginCustomerOnFrontendStep $loginCustomerOnFrontendStep
     * @param OpenSalesOrderOnFrontendForGuestStep $openSalesOrderOnFrontendForGuestStep
     * @param ObjectManager $objectManager
     * @param Customer $customer
     * @param Order $order
     */
    public function __construct(
        SalesGuestView $salesGuestView,
        $checkoutMethod,
        CmsIndex $cmsIndex,
        OrderView $orderView,
        LoginCustomerOnFrontendStep $loginCustomerOnFrontendStep,
        OpenSalesOrderOnFrontendForGuestStep $openSalesOrderOnFrontendForGuestStep,
        ObjectManager $objectManager,
        Customer $customer,
        Order $order
    ) {
        $this->objectManager = $objectManager;
        $this->salesGuestView = $salesGuestView;
        $this->checkoutMethod = $checkoutMethod;
        $this->cmsIndex =  $cmsIndex;
        $this->orderView = $orderView;
        $this->loginCustomerOnFrontendStep = $loginCustomerOnFrontendStep;
        $this->openSalesOrderOnFrontendForGuestStep = $openSalesOrderOnFrontendForGuestStep;
        $this->customer = $customer;
        $this->order = $order;
    }

    /**
     * Open RMA on frontend.
     *
     * @return void
     */
    public function run()
    {
        $this->checkoutMethod == 'login' ? $this->openRmaOnFrontendForCustomer() : $this->openRmaOnFrontendForGuest();
    }

    /**
     * Open RMA on frontend for Guest.
     */
    protected function openRmaOnFrontendForGuest()
    {
        $this->objectManager->create(
            'Mage\Sales\Test\TestStep\openSalesOrderOnFrontendForGuestStep',
            [
                'customer' => $this->customer,
                'order' => $this->order
            ]
        )->run();

        $this->salesGuestView->getViewBlock()->openLinkByName('Return');
    }

    /**
     * Open RMA on frontend for Customer.
     */
    protected function openRmaOnFrontendForCustomer()
    {
        $this->objectManager->create(
            'Mage\Customer\Test\TestStep\loginCustomerOnFrontendStep',
            ['customer' => $this->customer])->run();

        $this->cmsIndex->getTopLinksBlock()->openAccountLink('My Account');
        $this->orderView->getOrderViewBlock()->openLinkByName('View Order');
        $this->orderView->getOrderViewBlock()->openLinkByName('Return');
    }
}
