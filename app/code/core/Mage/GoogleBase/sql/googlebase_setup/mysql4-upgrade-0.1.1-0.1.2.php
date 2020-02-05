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
 * @package     Mage_GoogleBase
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

// encrypt google base passwords
$select = $installer->getConnection()->select()
    ->from($installer->getTable('core/config_data'))
    ->where('path LIKE ?', 'google/googlebase/password');
foreach ($installer->getConnection()->fetchAll($select) as $row) {
    $bind  = array(
        'value' => Mage::helper('core')->encrypt($row['value'])
    );
    $where = array(
        'config_id=?' => $row['config_id']
    );
    $installer->getConnection()->update($installer->getTable('core/config_data'), $bind, $where);
}