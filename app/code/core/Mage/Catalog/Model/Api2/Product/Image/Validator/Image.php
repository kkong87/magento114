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
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * API2 Product image validator
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Model_Api2_Product_Image_Validator_Image extends Mage_Api2_Model_Resource_Validator
{
    /**
     * Validate data. In case of validation failure return false,
     * getErrors() could be used to retrieve list of validation error messages
     *
     * @param array $data
     * @return bool
     */
    public function isValidData(array $data)
    {
        if (!isset($data['file_content']) || !isset($data['file_mime_type']) || empty($data['file_content']) ||
            empty($data['file_mime_type'])
        ) {
            $this->_addError('The image is not specified');
        }

        return !count($this->getErrors());
    }
}
