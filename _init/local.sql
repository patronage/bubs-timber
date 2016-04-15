## Update main site
UPDATE `wp_site` SET `domain` = 'www.bubs.dev' WHERE `id` = '1';
# UPDATE `wp_domain_mapping` SET `domain` = 'www.bubs.dev' WHERE `blog_id` = '1';
UPDATE `wp_blogs` SET `domain` = 'www.bubs.dev' WHERE `blog_id` = '1';

UPDATE `wp_sitemeta` SET `meta_value` = 'http://www.bubs.dev' WHERE `meta_key` = 'siteurl';
UPDATE `wp_options` SET `option_value` = 'http://www.bubs.dev' WHERE `option_name` = 'siteurl';
UPDATE `wp_options` SET `option_value` = 'http://www.bubs.dev' WHERE `option_name` = 'home';

## Film comment-logo
UPDATE `wp_site` SET `domain` = 'www.bubs2.dev' WHERE `id` = '2';
UPDATE `wp_blogs` SET `domain` = 'www.bubs2.dev' WHERE `blog_id` = '2';

UPDATE `wp_2_options` SET `option_value` = 'http://www.bubs2.dev' WHERE `option_name` = 'siteurl';
UPDATE `wp_2_options` SET `option_value` = 'http://www.bubs2.dev' WHERE `option_name` = 'home';
