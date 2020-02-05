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

namespace Mage\Sales\Test\Constraint;

use Mage\Sales\Test\Page\Adminhtml\SalesInvoiceView;
use Mage\Sales\Test\Page\Adminhtml\SalesInvoice;
use Magento\Mtf\ObjectManager;
use Magento\Mtf\System\Event\EventManagerInterface;

/**
 * Assert invoice items on invoice view page.
 */
class AssertInvoiceItems extends AbstractAssertItems
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Entity type.
     *
     * @var string
     */
    protected $entityType = 'invoice';

    /**
     * Special fields for verify.
     *
     * @var array
     */
    protected $specialFields = [
        'item_price',
        'item_subtotal',
        'item_tax',
        'item_discount',
        'item_row_total'
    ];

    /**
     * @constructor
     * @param ObjectManager $objectManager
     * @param EventManagerInterface $eventManager
     * @param SalesInvoice $invoiceIndex
     * @param SalesInvoiceView $orderInvoiceView
     */
    public function __construct(
        ObjectManager $objectManager,
        EventManagerInterface $eventManager,
        SalesInvoice $invoiceIndex,
        SalesInvoiceView $orderInvoiceView
    ) {
        parent::__construct($objectManager, $eventManager);
        $this->salesTypePage = $invoiceIndex;
        $this->salesTypeViewPage = $orderInvoiceView;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'All invoices products are present in invoice page.';
    }
}
