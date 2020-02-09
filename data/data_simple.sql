--
-- add type fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Type', 'supplier_idfs', 'history-base', 'articlehistory-single', 'col-md-2', '', '/contact/api/list/0', 0, 1, 0, 'entitytag-single', 'OnePlace\\Contact\\Model\\ContactTable','add-OnePlace\\Contact\\Controller\\ContactController'),
(NULL, 'datetime', 'Date', 'date', 'history-base', 'articlehistory-single', 'col-md-2', '', '', 0, 1, 0, '', '', ''),
(NULL, 'currency', 'Price', 'price', 'history-base', 'articlehistory-single', 'col-md-2', '', '', 0, 1, 0, '', '', ''),
(NULL, 'number', 'Amount', 'amount', 'history-base', 'articlehistory-single', 'col-md-1', '', '', 0, 1, 0, '', '', '');

