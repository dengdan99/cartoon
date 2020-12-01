ALTER TABLE `xwx_tags`
ADD COLUMN `is_show`  tinyint(1) UNSIGNED NULL DEFAULT 0 COMMENT '是否首页显示 默认不显示1显示' AFTER `cover_url`;

