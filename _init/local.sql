## Update main site
UPDATE `wp_options` SET `option_value` = 'http://wordpress.bubstimber.orb.local' WHERE `option_name` = 'siteurl';
UPDATE `wp_options` SET `option_value` = 'http://wordpress.bubstimber.orb.local' WHERE `option_name` = 'home';

## Alternate if using localhost instead of orb
-- UPDATE `wp_options` SET `option_value` = 'http://localhost:8000' WHERE `option_name` = 'siteurl';
-- UPDATE `wp_options` SET `option_value` = 'http://localhost:8000' WHERE `option_name` = 'home';


## Update multisites
-- UPDATE `wp_site` SET `domain` = 'localhost:8000' WHERE `id` = '1';
-- UPDATE `wp_blogs` SET `domain` = 'localhost:8000' WHERE `blog_id` = '1';

-- UPDATE `wp_sitemeta` SET `meta_value` = 'http://localhost:8000' WHERE `meta_key` = 'siteurl';

-- UPDATE `wp_site` SET `domain` = 'www.bubs2.dev' WHERE `id` = '2';
-- UPDATE `wp_blogs` SET `domain` = 'www.bubs2.dev' WHERE `blog_id` = '2';

-- UPDATE `wp_2_options` SET `option_value` = 'http://www.bubs2.dev' WHERE `option_name` = 'siteurl';
-- UPDATE `wp_2_options` SET `option_value` = 'http://www.bubs2.dev' WHERE `option_name` = 'home';

## Set local admin user login to: admin:password
UPDATE `wp_users` SET `user_login` = 'admin', `user_nicename` = 'admin' WHERE `ID` = '1';
UPDATE `wp_users` SET `user_pass` = '$P$BfuqvWHay8/zebob.mxuJvgSb.L0s4/' WHERE `ID` = '1';

## Prevent local dev errors  to propagate to a live admin email account.
UPDATE `wp_options` set `option_value` = 'dev@localhost.localdomain' where `option_name` = 'admin_email';
