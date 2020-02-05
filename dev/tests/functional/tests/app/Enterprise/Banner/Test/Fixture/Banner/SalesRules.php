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

namespace Enterprise\Banner\Test\Fixture\Banner;

use Mage\CatalogRule\Test\Fixture\CatalogRule;
use Mage\SalesRule\Test\Fixture\SalesRule;
use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

/**
 * Preset for sales rules.
 */
class SalesRules extends DataSource
{
    /**
     * Return sales rules.
     *
     * @var CatalogRule[]
     */
    protected $salesRules = [];

    /**
     * @constructor
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['presets'])) {
            $presets = explode(',', $data['presets']);
            foreach ($presets as $preset) {
                /** @var SalesRule $salesRules */
                $salesRules = $fixtureFactory->createByCode('salesRule', ['dataset' => $preset]);
                if (!$salesRules->getRuleId()) {
                    $salesRules->persist();
                }

                $this->data[] = $salesRules->getRuleId();
                $this->salesRules[] = $salesRules;
            }
        } else {
            $this->data[] = $data;
        }
    }

    /**
     * Return sales rules fixture.
     *
     * @return array
     */
    public function getSalesRules()
    {
        return $this->salesRules;
    }
}
