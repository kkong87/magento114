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
 * @package     Mage_Core
 * @copyright Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->run("
CREATE TABLE IF NOT EXISTS `{$installer->getTable('core/cache')}` (
        `id` VARCHAR(255) NOT NULL,
        `data` mediumblob,
        `create_time` int(11),
        `update_time` int(11),
        `expire_time` int(11),
        PRIMARY KEY  (`id`),
        KEY `IDX_EXPIRE_TIME` (`expire_time`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('core/cache_tag')}` (
    `tag` VARCHAR(255) NOT NULL,
    `cache_id` VARCHAR(255) NOT NULL,
    KEY `IDX_TAG` (`tag`),
    KEY `IDX_CACHE_ID` (`cache_id`),
    CONSTRAINT `FK_CORE_CACHE_TAG` FOREIGN KEY (`cache_id`) REFERENCES `{$installer->getTable('core/cache')}` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `{$installer->getTable('core/cache_option')}` (
        `code` VARCHAR(32) NOT NULL,
        `value` tinyint(3),
        PRIMARY KEY  (`code`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

");
