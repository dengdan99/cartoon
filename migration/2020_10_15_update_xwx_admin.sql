ALTER TABLE `xwx_admin`
ADD COLUMN `type_id`  tinyint(2) UNSIGNED NULL DEFAULT 1 COMMENT '1 超级管理员， 2网站管理员' AFTER `last_login_ip`;

