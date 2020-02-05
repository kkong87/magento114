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

namespace Enterprise\Rma\Test\Fixture\Rma;

use Mage\Sales\Test\Fixture\Order;
use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Order id source for rma.
 */
class OrderId extends DataSource
{

    /**
     * Order source.
     *
     * @var Order
     */
    protected $order;

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['order'])) {
            $this->order = $data['order'];
        } elseif (isset($data['dataset'])) {
            $this->order = $fixtureFactory->createByCode(
                'order',
                ['dataset' => isset($data['dataset']) ? $data['dataset'] : 'default']
            );
            if (!$this->order->hasData('id')) {
                $this->order->persist();
            }
        }

        $this->data = $this->order->getData('id');
    }

    /**
     * Return order source.
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
