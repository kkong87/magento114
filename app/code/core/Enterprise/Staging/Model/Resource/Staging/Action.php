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
 * @package     Enterprise_Staging
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Staging action resource
 *
 * @category    Enterprise
 * @package     Enterprise_Staging
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Staging_Model_Resource_Staging_Action extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     *
     */
    protected function _construct()
    {
        $this->_init('enterprise_staging/staging_action', 'action_id');
    }

    /**
     * Before save processing
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Enterprise_Staging_Model_Resource_Staging_Action
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $staging = $object->getStaging();
        if ($staging instanceof Enterprise_Staging_Model_Staging) {
            if ($staging->getId()) {
                $object->setStagingId($staging->getId());
                $object->setStagingWebsiteId($staging->getStagingWebsiteId());
                $object->setMasterWebsiteId($staging->getMasterWebsiteId());
            }
        }

        if (!$object->getId() && !$object->getCreatedAt()) {
            $value = $this->formatDate(time());
            $object->setCreatedAt($value);
        }
        if ($object->getId()) {
            $value = $this->formatDate(time());
            $object->setUpdatedAt($value);
        }

        parent::_beforeSave($object);

        return $this;
    }

    /**
     * Action after delete
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterDelete(Mage_Core_Model_Abstract $object)
    {
        return parent::_afterDelete($object);
    }

    /**
     * Action get backup tables
     *
     * @param $stagingTablePrefix
     * @return Enterprise_Staging_Model_Resource_Helper_Mysql4
     */
    public function getBackupTables($stagingTablePrefix)
    {
        return Mage::getResourceHelper('enterprise_staging')->getTableNamesByPrefix($stagingTablePrefix);
    }

    /**
     * Action delete staging backup
     * Need to delete all backup tables without transaction
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Enterprise_Staging_Model_Resource_Staging_Action
     */
    public function deleteStagingBackup(Mage_Core_Model_Abstract $object)
    {
        if ($object->getIsDeleteTables() === true) {
            $stagingTablePrefix = $object->getStagingTablePrefix();
            $tables = Mage::getResourceHelper('enterprise_staging')->getTableNamesByPrefix($stagingTablePrefix);
            $connection = $this->_getWriteAdapter();

            foreach ($tables AS $table) {
                $connection->disableTableKeys($table);
                $connection->dropTable($table);
            }

        }
        return $this;
    }
}
