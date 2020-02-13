--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('article-history', 'article-single', 'History', 'Recent Article', 'fas fa-history', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'History', 'article_history', 'article-history', 'article-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- add button
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Add History', 'fas fa-history', 'Add History', '/article/history/add/##ID##', 'primary', '', 'article-view', 'link', '', ''),
(NULL, 'Save History', 'fas fa-save', 'Save History', '#', 'primary saveForm', '', 'articlehistory-single', 'link', '', '');

--
-- create history table
--
CREATE TABLE `article_history` (
  `History_ID` int(11) NOT NULL,
  `article_idfs` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` TEXT NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `article_history`
  ADD PRIMARY KEY (`History_ID`);

ALTER TABLE `article_history`
  MODIFY `History_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- add history form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('articlehistory-single', 'Article History', 'OnePlace\\Article\\History\\Model\\History', 'OnePlace\\Article\\History\\Model\\HistoryTable');

--
-- add form tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('history-base', 'articlehistory-single', 'History', 'Recent Article', 'fas fa-history', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Comment', 'comment', 'history-base', 'articlehistory-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Article', 'article_idfs', 'history-base', 'articlehistory-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');

--
-- permission add history
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Article\\History\\Controller\\HistoryController', 'Add History', '', '', '0');