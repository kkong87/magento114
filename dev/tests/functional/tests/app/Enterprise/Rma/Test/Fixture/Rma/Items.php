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

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Repository\RepositoryFactory;

/**
 * Source for rma items field.
 *
 * Data keys:
 *  - products (array of products fixtures)
 *  - presets (name preset's)
 *  - data (data for field)
 */
class Items extends DataSource
{

    /**
     * Array of products' fixtures.
     *
     * @var array
     */
    protected $products;

    /**
     * @constructor
     * @param RepositoryFactory $repositoryFactory
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(RepositoryFactory $repositoryFactory, FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        $this->data = isset($data['dataset']) && isset($this->params['repository'])
            ?  $repositoryFactory->get($this->params['repository'])->get($data['dataset'])
            : [];
        if (isset($data['data'])) {
            $this->data = array_replace_recursive($this->data, $data['data']);
        }
        if (isset($data['products'])) {
            $this->products = $data['products'];
        }
    }

    /**
     * Get array of products' fixtures.
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

}
