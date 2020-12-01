ALTER TABLE `xwx_banner`
ADD COLUMN `platform`  varchar(200) NULL DEFAULT '' COMMENT '平台:H5/PC' AFTER `pic_name`;

