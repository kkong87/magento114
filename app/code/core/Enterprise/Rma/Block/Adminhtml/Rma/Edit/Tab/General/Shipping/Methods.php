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
 * @category    Enterprise
 * @package     Enterprise_Rma
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

class Enterprise_Rma_Block_Adminhtml_Rma_Edit_Tab_General_Shipping_Methods extends Mage_Core_Block_Template
{
    /**
     * @var Enterprise_Rma_Helper_Data
     */
    private $rmaHelperData;

    /**
     * @var Mage_Usa_Model_Shipping_Carrier_Abstract[]|array
     */
    private $carriers;

    public function _construct()
    {
        parent::_construct();
        $this->rmaHelperData = Mage::helper('enterprise_rma');
        $this->setShippingMethods($this->getAvailableShippingMethods());
    }

    public function getShippingPrice($price)
    {
        return Mage::registry('current_rma')
            ->getStore()
            ->convertPrice(
                Mage::helper('tax')->getShippingPrice(
                    $price
                ),
                true,
                false
            )
        ;
    }

    public function jsonData($method)
    {
        $data = array();
        $data['CarrierTitle']   = $method->getCarrierTitle();
        $data['MethodTitle']    = $method->getMethodTitle();
        $data['Price']          = $this->getShippingPrice($method->getPrice());
        $data['PriceOriginal']  = $method->getPrice();
        $data['Code']           = $method->getCode();

        return Mage::helper('core')->jsonEncode($data);
    }

    /**
     * Gets shipping method carrier by shipping method code.
     *
     * @param $code
     * @param $storeId
     * @return Mage_Usa_Model_Shipping_Carrier_Abstract
     */
    private function getCarrier($code, $storeId)
    {
        if (empty($this->carriers[$code])) {
            $carrier = $this->rmaHelperData->getCarrier($code, $storeId);
            $this->carriers[$code] = $carrier;
        }

        return $this->carriers[$code];
    }

    /**
     * Gets list of shipping methods which provide possibility to create shipping labels.
     *
     * @return array
     */
    private function getAvailableShippingMethods()
    {
        /** @var Enterprise_Rma_Model_Rma $rmaModel */
        $rmaModel = Mage::registry('current_rma');
        $methods = $rmaModel->getShippingMethods();
        $storeId = $rmaModel->getStoreId();

        $allowed = array_filter($methods, function ($method) use ($storeId) {
            /** @var Mage_Sales_Model_Quote_Address_Rate $method */
            $carrier = $this->getCarrier($method->getCode(), (int) $storeId);
            return $carrier->isShippingLabelsAvailable();
        });

        return $allowed;
    }
}
