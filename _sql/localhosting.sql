UPDATE `wp_users` SET `user_login` = 'admin', `user_nicename` = 'admin' WHERE `ID` = '2';
UPDATE `wp_users` SET `user_pass` = '$P$BfuqvWHay8/zebob.mxuJvgSb.L0s4/' WHERE `ID` = '2';
UPDATE `wp_options` SET `option_value` = 'http://localhost:8000' where `option_id` = '1';
UPDATE `wp_options` SET `option_value` = 'http://localhost:8000' where `option_id` = '2';
