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

namespace Enterprise\GiftRegistry\Test\Block\Customer\Edit;

use Magento\Mtf\Client\Locator;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Registrants information.
 */
class EventInformation extends SimpleElement
{
    /**
     * Event information fields selectors
     *
     * @var array
     */
    protected $info = [
        'event_country' => [
            'selector' => '[name$="event_country"]',
            'input' => 'select'
        ],
        'event_country_region' => [
            'selector' => '[name$="event_country_region"]',
            'input' => 'select'
        ],
        'event_country_region_text' => [
            'selector' => '[name$="event_country_region_text"]',
        ],
        'event_date' => [
            'selector' => '[name$="event_date"]'
        ],
        'event_location' => [
            'selector' => '[name$="event_location"]'
        ],
        'number_of_guests' => [
            'selector' => '[name$="[number_of_guests]"]'
        ],
        'email' => [
            'selector' => '[name$="[number_of_guests]"]'
        ],
    ];

    /**
     * Set event information.
     *
     * @param array $info
     * @return void
     */
    public function setValue($info)
    {
        foreach ($info as $field => $value) {

            $input = isset($this->info[$field]['input']) ? $this->info[$field]['input'] : null;
            $this->find($this->info[$field]['selector'], Locator::SELECTOR_CSS, $input)->setValue($value);
        }
    }

    /**
     * Get event information.
     *
     * @return array
     */
    public function getValue()
    {
        $info = [];
        foreach ($this->info as $field => $locator) {
            $input = isset($locator['input']) ? $locator['input'] : null;
            $element = $this->find($locator['selector'], Locator::SELECTOR_CSS, $input);
            if ($element->isVisible()) {
                $info[$field] = $element->getValue();
            }
        }
        return $info;
    }
}
