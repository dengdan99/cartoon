ALTER TABLE `xwx_tags`
ADD COLUMN `sort`  int(10) UNSIGNED NULL DEFAULT 0 COMMENT '排序' AFTER `is_show`;

