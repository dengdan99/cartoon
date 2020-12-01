ALTER TABLE `xwx_book`
ADD COLUMN `clicks`  int(11) UNSIGNED NULL DEFAULT 0 COMMENT '初始化点击量' AFTER `tags_id`;

