-- =======================================================================================
-- =======================================================================================
-- =======================================================================================

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- =======================================================================================
--										ACCOUNT
-- =======================================================================================

DROP TABLE IF EXISTS `ls_AccountUser`;
CREATE TABLE IF NOT EXISTS `ls_AccountUser` (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_name` varchar(32) NOT NULL DEFAULT 'none',
  `account_password` varchar(255) NOT NULL DEFAULT 'none',
  `account_email` varchar(100) NOT NULL DEFAULT 'none',
  `account_code` varchar(32) NOT NULL DEFAULT '0',
  `agent` varchar(128) NOT NULL DEFAULT 'none',
  `app_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `level_access` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `level_penalty` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `level_experience` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `experience` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `banned` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									ONLINE ACCOUNTS
-- =======================================================================================

DROP TABLE IF EXISTS `ls_AccountUserOnline`;
CREATE TABLE IF NOT EXISTS `ls_AccountUserOnline` (
  `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sid` varchar(64) NOT NULL DEFAULT 'unknown',
  `ip` varchar(64) NOT NULL DEFAULT 'unknown',
  `agent` varchar(128) NOT NULL DEFAULT 'none',
  `key_public` varchar(8) NOT NULL DEFAULT 'key12345',
  `account_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `app_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									SCHEDULED TASKS
-- =======================================================================================

DROP TABLE IF EXISTS `ls_SystemScheduledTasks`;
CREATE TABLE IF NOT EXISTS `ls_SystemScheduledTasks` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_name` varchar(64) NOT NULL DEFAULT 'none',
	`task_chance` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`task_interval` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`task_lifetime` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`task_count` int(11) UNSIGNED NOT NULL DEFAULT '0', 
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ls_SystemScheduledTasks` (`uid`, `task_name`, `task_chance`, `task_interval`, `task_lifetime`) VALUES
(01, 'PruneOnlineClients',				'100', 	'360', 	'0' ),
(02, 'PruneOnlineAccounts', 			'100', 	'360', 	'0' ),
(03, 'PruneUnconfirmedAccounts', 		'100', 	'360', 	'3600' ),
(04, 'PruneBannedAccounts', 			'100', 	'360', 	'36000' ),
(05, 'PruneDeletedAccounts', 			'100', 	'360', 	'36000' ),
(06, 'BanPenalizedAccounts',			'100', 	'360', 	'0' ),
(07, 'WipeAllAccounts',					'100', 	'360', 	'3600' );

-- =======================================================================================
--									REGISTER TASKS
-- =======================================================================================

DROP TABLE IF EXISTS `ls_SystemRegisterTasks`;
CREATE TABLE IF NOT EXISTS `ls_SystemRegisterTasks` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`task_name` varchar(64) NOT NULL DEFAULT 'none',
	`task_access` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ls_SystemRegisterTasks` (`uid`, `task_name`, `task_access`) VALUES
(01, 'AddVirtualCurrencies',	'0' ),
(02, 'AddVirtualGoods',			'0' ),
(03, 'AddVirtualProperties',	'0' ),
(04, 'AddVirtualEntities',		'0' );

-- =======================================================================================
--									VIRTUAL CURRENCIES
-- =======================================================================================

DROP TABLE IF EXISTS `ls_VirtualCurrencies`;
CREATE TABLE IF NOT EXISTS `ls_VirtualCurrencies` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`active` tinyint(3) NOT NULL DEFAULT '1',
	`app_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`value_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`value_max` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`value_growth` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`value_interval` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`value_levelup_growth` int(11) NOT NULL DEFAULT '0',
	`value_levelup_max` int(11) NOT NULL DEFAULT '0',
	`value_levelup_interval` int(11) NOT NULL DEFAULT '0',
	
	`is_sellable` tinyint(3) NOT NULL DEFAULT '1',
	`is_buyable` tinyint(3) NOT NULL DEFAULT '1',
	`is_giftable` tinyint(3) NOT NULL DEFAULT '1',
	
	`buy_uid` int(11) NOT NULL DEFAULT '0',
	`buy_amount` int(11) NOT NULL DEFAULT '0',
	`sell_uid` int(11) NOT NULL DEFAULT '0',
	`sell_amount` int(11) NOT NULL DEFAULT '0',
	
	
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ls_VirtualCurrencies` (`uid`, `active`, `app_id`, `value_start`, `value_max`, `value_growth`, `value_interval`, `value_levelup_growth`, `value_levelup_max`, `value_levelup_interval`, `is_sellable`, `is_buyable`, `is_giftable`, `buy_uid`, `buy_amount`, `sell_uid`, `sell_amount`) VALUES
(01, '1', '1', '5',		'50', 	'1', '60', '1', '1', '-1', '1', '1', '1',		'1', '5', '2', '2'),
(02, '1', '1', '10', 	'100', 	'1', '90', '1', '1', '-1', '1', '1', '1',		'1', '5', '1', '2'),
(03, '1', '1', '15', 	'150', 	'0', '0' , '0', '1', '0',  '1', '1', '1',		'1', '5', '1', '2'),
(04, '1', '1', '20', 	'200',	'0', '0' , '0', '1', '0',  '1', '1', '1',		'1', '5', '1', '2'),
(05, '1', '1', '25', 	'250',	'0', '0' , '0', '1', '0',  '1', '1', '1',		'1', '5', '1', '2');

DROP TABLE IF EXISTS `ls_AccountVirtualCurrencies`;
CREATE TABLE IF NOT EXISTS `ls_AccountVirtualCurrencies` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`currency_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`account_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`amount` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- =======================================================================================
--									VIRTUAL GOODS
-- =======================================================================================

DROP TABLE IF EXISTS `ls_VirtualGoods`;
CREATE TABLE IF NOT EXISTS `ls_VirtualGoods` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`active` tinyint(3) NOT NULL DEFAULT '1',
	`app_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	
	`amount_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`amount_max` int(11) UNSIGNED NOT NULL DEFAULT '0',

	`is_sellable` tinyint(3) NOT NULL DEFAULT '1',
	`is_buyable` tinyint(3) NOT NULL DEFAULT '1',
	`is_giftable` tinyint(3) NOT NULL DEFAULT '1',
		
	`buy_uid` int(11) NOT NULL DEFAULT '0',
	`buy_amount` int(11) NOT NULL DEFAULT '0',
	`sell_uid` int(11) NOT NULL DEFAULT '0',
	`sell_amount` int(11) NOT NULL DEFAULT '0',
	
	
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ls_VirtualGoods` (`uid`, `active`, `app_id`, `amount_start`, `amount_max`, `is_sellable`, `is_buyable`, `is_giftable`, `buy_uid`, `buy_amount`, `sell_uid`, `sell_amount`) VALUES
(01, '1', '1', '5',		'50', 	'1', '1', '1',		'1', '5',   '1', '1' ),
(02, '1', '1', '10', 	'100', 	'1', '1', '1',		'1', '10',  '1', '2' ),
(03, '1', '1', '15', 	'150', 	'1', '1', '1',		'1', '15' , '1', '3' ),
(04, '1', '1', '20', 	'200',	'1', '1', '1',		'1', '20' , '1', '4' ),
(05, '1', '1', '25', 	'250',	'1', '1', '1',		'1', '25' , '1', '5' );

DROP TABLE IF EXISTS `ls_AccountVirtualGoods`;
CREATE TABLE IF NOT EXISTS `ls_AccountVirtualGoods` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`good_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`account_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`amount` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									VIRTUAL PROPERTIES
-- =======================================================================================

DROP TABLE IF EXISTS `ls_VirtualProperties`;
CREATE TABLE IF NOT EXISTS `ls_VirtualProperties` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`active` tinyint(3) NOT NULL DEFAULT '1',
	`app_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	
	`level_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`level_max` int(11) UNSIGNED NOT NULL DEFAULT '0',
	
	`produce_uid` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_storage` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_growth` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_interval` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_levelup_growth` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_levelup_max` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_levelup_interval` int(11) UNSIGNED NOT NULL DEFAULT '0',

	`is_sellable` tinyint(3) NOT NULL DEFAULT '1',
	`is_buyable` tinyint(3) NOT NULL DEFAULT '1',

	`buy_uid` int(11) NOT NULL DEFAULT '0',
	`buy_amount` int(11) NOT NULL DEFAULT '0',
	`sell_uid` int(11) NOT NULL DEFAULT '0',
	`sell_amount` int(11) NOT NULL DEFAULT '0',
	
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ls_VirtualProperties` (`uid`, `active`, `app_id`, `produce_uid`, `produce_storage`, `produce_growth`, `produce_interval`, `produce_levelup_growth`, `produce_levelup_max`, `produce_levelup_interval`, `is_sellable`, `is_buyable`, `buy_uid`, `buy_amount`, `sell_uid`, `sell_amount`) VALUES
(01, '1', '1', '1',		'50', 	'1', '60', '1', '5', '-1',	 '1', '1', 		'1', '5', '1', '2'),
(02, '1', '1', '2', 	'100', 	'2', '90', '1', '5', '-1', 	 '1', '1', 		'1', '5', '1', '2'),
(03, '1', '1', '3', 	'150', 	'3', '30' , '1', '5', '0', 	 '1', '1', 		'1', '5', '1', '2'),
(04, '1', '1', '4', 	'200',	'4', '90' , '1', '5', '-1',  '1', '1', 		'1', '5', '1', '2'),
(05, '1', '1', '5', 	'250',	'5', '60' , '1', '5', '0', 	 '1', '1', 		'1', '5', '1', '2');

DROP TABLE IF EXISTS `ls_AccountVirtualProperties`;
CREATE TABLE IF NOT EXISTS `ls_AccountVirtualProperties` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`property_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`account_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`level` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`produce_amount` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									VIRTUAL ENTITIES
-- =======================================================================================

DROP TABLE IF EXISTS `ls_VirtualEntities`;
CREATE TABLE IF NOT EXISTS `ls_VirtualEntities` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`active` tinyint(3) NOT NULL DEFAULT '1',
	`app_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	
	`level_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`level_max` int(11) UNSIGNED NOT NULL DEFAULT '0',
	
	`grade_start` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`grade_max` int(11) UNSIGNED NOT NULL DEFAULT '0',


	`is_sellable` tinyint(3) NOT NULL DEFAULT '1',
	`is_buyable` tinyint(3) NOT NULL DEFAULT '1',

	`buy_uid` int(11) NOT NULL DEFAULT '0',
	`buy_amount` int(11) NOT NULL DEFAULT '0',
	`sell_uid` int(11) NOT NULL DEFAULT '0',
	`sell_amount` int(11) NOT NULL DEFAULT '0',
	
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `ls_VirtualEntities` (`uid`, `active`, `app_id`, `level_start`, `level_max`, `grade_start`, `grade_max`, `is_sellable`, `is_buyable`, `buy_uid`, `buy_amount`, `sell_uid`, `sell_amount`) VALUES
(01, '1', '1',	'1', '40', '1', '6', 	 '1', '1', 		'1', '5', '1', '2'),
(02, '1', '1', 	'1', '40', '1', '6', 	 '1', '1', 		'1', '5', '1', '2'),
(03, '1', '1', 	'1', '40', '1', '6', 	 '1', '1', 		'1', '5', '1', '2'),
(04, '1', '1', 	'1', '40', '1', '6',  	 '1', '1', 		'1', '5', '1', '2'),
(05, '1', '1', 	'1', '40', '1', '6', 	 '1', '1', 		'1', '5', '1', '2');

DROP TABLE IF EXISTS `ls_AccountVirtualEntities`;
CREATE TABLE IF NOT EXISTS `ls_AccountVirtualEntities` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`entity_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`account_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`level` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`grade` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									SOCIAL CHAT
-- =======================================================================================

DROP TABLE IF EXISTS `ls_SocialChat`;
CREATE TABLE IF NOT EXISTS `ls_SocialChat` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	
	`sender_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`channel` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
	`message` text NOT NULL,
	`type` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',

	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									SOCIAL MESSAGES
-- =======================================================================================

DROP TABLE IF EXISTS `ls_SocialMessages`;
CREATE TABLE IF NOT EXISTS `ls_SocialMessages` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	
	`sender_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`recipient_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`viewed` tinyint(3) NOT NULL DEFAULT '0',
	`message` text NOT NULL,
	`currency_uid` int(11) NOT NULL DEFAULT '0',
	`currency_amount` int(11) NOT NULL DEFAULT '0',
	`good_uid` int(11) NOT NULL DEFAULT '0',
	`good_amount` int(11) NOT NULL DEFAULT '0',	
	
	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									SOCIAL FRIENDLIST
-- =======================================================================================

DROP TABLE IF EXISTS `ls_SocialFriendlist`;
CREATE TABLE IF NOT EXISTS `ls_SocialFriendlist` (
	`uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

	`account_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`friend_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
	`confirmed` tinyint(3) NOT NULL DEFAULT '0',

	`tstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`uid`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- =======================================================================================
--									
-- =======================================================================================


-- =======================================================================================
-- =======================================================================================
-- =======================================================================================