# 1.环境要求
    PHP 7.0-7.3（最好是7.3）
    MySQL 版本 >= 5.7  
    Redis（版本越高越好）
    PHP的Redis扩展
    nginx

# 2.nginx配置
```
server {
    listen       80;
    server_name m.manhua-php.net admin.manhua-php.net api.manhua-php.net;
    index index.html index.htm index.php;
    root /var/www/html/cartoon/public;
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
        expires      30d;
    }
    location ~ .*\.(js|css)?$ {
        expires      1h;
    }
    try_files $uri $uri/ @rewrite;
    location @rewrite {
        if (!-e $request_filename) {  
            rewrite  ^(.*)$  /index.php?s=/$1  last;  
            break;  
        }  
        rewrite ^/template/(.*).(html)$ 404.html last;
    }

    location ~ \.php$ {
        root           html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;
    }
}
```
# 3.程序环境
    1.cp env.template .env
    2.修改配置:vim .env
    ```
        #域名配置需要和nginx和config/app.php文件domain_bind列表配置对应
        APP_DEBUG = true
        BIND_MOBILE = m.manhua-php.net
        BIND_ADMIN = admin.manhua-php.net
        BIND_MIP = mip.manhua-php.net
        BIND_API = api.manhua-php.net
        BIND_APP = app.manhua-php.net
        BIND_AUTHOR = author.manhua-php.net
        BIND_INDEX = www.manhua-php.net

        [APP]
        DEFAULT_TIMEZONE = Asia/Shanghai
        #数据库
        [DATABASE]
        TYPE = mysql
        HOSTNAME = 
        DATABASE = 
        USERNAME = 
        PASSWORD = 
        HOSTPORT = 
        CHARSET = 
        DEBUG = true
        PREFIX = xwx_
        #redis缓存
        [CACHE]
        HOSTNAME = 
        PORT = 
        PASSWORD = 
        PREFIX = 5e35013:

        [LANG]
        default_lang = zh-cn
    ```
    3.文件权限修改，需要php运行用户对下面两个文件有写权限
       config/site.php
       config/payment.php
       config/page.php
       
# 4.导入初始化数据
    mysql -uroot -p cartoon < install.sql
    