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

use Mage\Adminhtml\Test\Fixture\Store;
use Mage\Adminhtml\Test\Fixture\StoreGroup;
use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Repository\RepositoryFactory;

/**
 * Preset for store contents.
 */
class StoreContents extends DataSource
{

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Store name.
     *
     * @var string
     */
    protected $store;

    /**
     * @constructor
     * @param RepositoryFactory $repositoryFactory
     * @param FixtureFactory $fixtureFactory
     * @param array $params
     * @param array $data [optional]
     */
    public function __construct(RepositoryFactory $repositoryFactory, FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->fixtureFactory = $fixtureFactory;
        $this->params = $params;
        $this->data = $this->prepareData($repositoryFactory, $data);;
    }

    /**
     * @param RepositoryFactory $repositoryFactory
     * @param array $data
     * @return array
     */
    protected function prepareData(RepositoryFactory $repositoryFactory, array $data)
    {
        $dataset = [];
        if (isset($data['dataset']) && isset($this->params['repository'])) {
            $dataset = $repositoryFactory->get($this->params['repository'])->get($data['dataset']);
            unset($data['dataset']);
        }

        $data = empty($dataset) ? $data : array_replace_recursive($dataset, $data);
        if (isset($data['store_views'])) {
            $data['store_views'] = $this->prepareStoreViewContent($data['store_views']);
        }
        return $data;
    }

    /**
     * Prepare store view content.
     *
     * @param array $storeViews
     * @return array
     */
    protected function prepareStoreViewContent(array $storeViews)
    {
        $result = [];
        foreach ($storeViews as $storeView) {
            if (isset($storeView['store_view']['dataset'])) {
                /** @var Store $storeViewFixture */
                $storeViewFixture = $this->fixtureFactory->createByCode('store', $storeView['store_view']);
                if (!$storeViewFixture->hasData('store_id')) {
                    $storeViewFixture->persist();
                }
                $result[$storeViewFixture->getStoreId()] = [
                    'store_view' => 'No',
                    'store_view_content' => $storeView['store_view_content']
                ];
                $this->store = $storeViewFixture->getGroupId() . '/' . $storeViewFixture->getName();
            }
        }

        return $result;
    }

    /**
     * Get store.
     *
     * @return string|null
     */
    public function getStore()
    {
        return $this->store;
    }
}
