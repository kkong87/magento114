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

use Enterprise\Rma\Test\Page\RmaReturn;
use Enterprise\Rma\Test\Fixture\Rma;
use Mage\Sales\Test\Fixture\Order;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestStep\TestStepInterface;
use Enterprise\Rma\Test\Page\RmaCreate;

/**
 * Create RMA on frontend for step.
 */
class CreateRmaOnFrontendStep implements TestStepInterface
{
    /**
     * Rma create page.
     *
     * @var RmaCreate
     */
    protected $rmaCreate;

    /**
     * Rma fixture.
     *
     * @var Rma
     */
    protected $rma;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Rma return page.
     *
     * @var RmaReturn
     */
    protected $rmaReturn;

    /**
     * Fixture of order.
     *
     * @var Order
     */
    protected $order;

    /**
     * Array of products fixtures.
     *
     * @var array
     */
    protected $products;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param RmaCreate $rmaCreate
     * @param RmaReturn $RmaReturn
     * @param Rma $rma
     * @param Order $order
     * @param array $products [optional]
     */
    public function __construct(
        FixtureFactory $fixtureFactory,
        RmaCreate $rmaCreate,
        RmaReturn $RmaReturn,
        Rma $rma,
        Order $order,
        array $products = []
    ) {
        $this->rmaCreate = $rmaCreate;
        $this->rmaReturn = $RmaReturn;
        $this->fixtureFactory = $fixtureFactory;
        $this->products = $products;
        $this->order = $order;
        $this->rma = $this->updateRmaFixture($rma);
    }

    /**
     * Create RMA on frontend for Guest.
     *
     * @return array
     */
    public function run()
    {
        $this->rmaCreate->getCreateBlock()->fill($this->rma);
        $this->rmaCreate->getCreateBlock()->submit();

        return ['rma' => $this->updateRmaFixture($this->rma, $this->getRmaId())];
    }

    /**
     * Update RMA fixture.
     *
     * @param Rma $rma
     * @param null|string $rmaId
     * @return Rma
     */
    protected function updateRmaFixture(Rma $rma, $rmaId = null)
    {
        $newData = $rma->getData();
        $newData['items'] = [
            'data' => $newData['items'],
            'products' => $this->products,
        ];
        $newData['order_id'] = [
            'order' => $this->order
        ];
        if ($rmaId !== null) {
            $newData['entity_id'] = $rmaId;
        }

        return $this->fixtureFactory->createByCode('rma', ['data' => $newData]);
    }

    /**
     * Get RMA id.
     *
     * @return null|string
     */
    protected function getRmaId()
    {
        return $this->rmaReturn->getMessagesBlock()->getId();
    }
}
