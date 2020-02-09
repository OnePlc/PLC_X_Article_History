ALTER TABLE `article_history` ADD `supplier_idfs` INT(11) NOT NULL DEFAULT '0' AFTER `article_idfs`,
ADD `date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `supplier_idfs`,
ADD `price` FLOAT NOT NULL DEFAULT 0 AFTER `date`,
ADD `amount` FLOAT NOT NULL DEFAULT 0 AFTER `price`;

