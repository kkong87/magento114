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

namespace Enterprise\GiftWrapping\Test\Block\Adminhtml\Giftwrapping\Edit;

use Enterprise\GiftWrapping\Test\Fixture\GiftWrapping;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Fixture\FixtureInterface;

/**
 * Form for gift wrapping creation/editing.
 */
class Form extends \Magento\Mtf\Block\Form
{
    /**
     * Selector for website field.
     *
     * @var string
     */
    protected $website = '#website_ids';

    /**
     * Fill the root form
     *
     * @param FixtureInterface $giftWrapping
     * @param SimpleElement|null $element
     * @return $this
     */
    public function fill(FixtureInterface $giftWrapping, SimpleElement $element = null)
    {
        $this->fillWebsites($giftWrapping);
        return parent::fill($giftWrapping);
    }

    /**
     * Fill website.
     *
     * @param GiftWrapping $giftWrapping
     * @return void
     */
    protected function fillWebsites(GiftWrapping $giftWrapping)
    {
        $websiteField = $this->_rootElement->find($this->website, Locator::SELECTOR_CSS, 'multiselectlist');
        if ($websiteField->isVisible() && !$giftWrapping->hasData('website_ids')) {
            $websiteField->setValue('Main Website');
        }
    }

    /**
     * Get data of the root form
     *
     * @param FixtureInterface|null $fixture
     * @param SimpleElement|null $element
     * @return array
     */
    function getData(FixtureInterface $fixture = null, SimpleElement $element = null)
    {
        $data = [];
        $websiteField = $this->_rootElement->find($this->website, Locator::SELECTOR_CSS, 'multiselectlist');
        if (null === $fixture) {
            $fields = null;
        } else {
            $isHasData = ($fixture instanceof InjectableFixture) ? $fixture->hasData() : true;
            $data = $isHasData ? $fixture->getData() : [];
            $fields = isset($data['fields']) ? $data['fields'] : $data;
        }
        $mapping = $this->dataMapping($fields);
        if (isset($mapping['website_ids']) && !($websiteField->isVisible())) {
            unset($mapping['website_ids']);
        }
        return $this->_getData($mapping, $element);
    }
}
