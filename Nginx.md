##Nginx介绍##
Nginx是 Igo Sysoev编写的一个HTTP和反向代理服务器,
另外它也可以作为邮件服务器.
目前主流的互联网公司360,百度,新浪,腾讯,阿里
都在使用nginx作为自己的web服务器.

##官网文档 
[链接](http://nginx.org/en/docs/)

Nginx有**内核**和**模块**组成.

其中,**内核**的设计非常微小和简洁,完成的工作也非常简单,

仅仅通过查找配置文件将客户端请求映射到一个location区块 

(location是Nginx配置中的一个指令,用于URL匹配),

而在这个location中说配置的每个指令将会启动不同的模块去完成相应的工作


Nginx的**模块**从结构上分为:

 - **核心模块:** HTTP模块,Event模块和Mail模块(邮件)

 - **基础模块:** HTTP Access模块,HTTP FastCGI模块,HTTP Proxy模块
和HTTP Rewrite模块

 - **第三方模块:** HTTP Upstream Request Hash模块,Notice模块和
HTTP Access Key模块.




##Nginx相对于Apache的优点:##
 - 高并发响应性能非常好,官方Nginx处理静态文件并发5W/s
 - 反向代理性能非常好(可用与于负载均衡)
 - 内存和CPU占用率低(是Apache的1/5-1/10)
 - 功能较Apache少(常用功能都有)  缺点
 - 对PHP可使用CGI通用网关接口(Common Gateway Interface)方式和FastCgi方式

##Nginx安装##

 - **yun安装(自动解决依赖)**

设置yum安装源

touch /etc/yum.repos.d/nginx.repo

粘贴以下内容

[nginx]
name=nginx repo

baseurl=http://nginx.org/packages/centos/6/$basearch/

gpgcheck=0

enabled=1

然后

1. 安装
 
	yum install nginx

2. 配置

	nano /etc/nginx/nginx.conf
	nano /etc/nginx/conf.d/default.conf

3. 查看进程

	ps aux|grep nginx

	ps -ef | grep nginx

4. 启动nginx

	service nginx start

5. 开机启动
	
	chkconfig nginx on

6. 测试nginx命令

nginx -t

nginx: the configuration file /etc/nginx/nginx.conf syntax is ok

nginx: configuration file /etc/nginx/nginx.conf test is successful

显示上面就可以了


- **源码安装**


首先安装 pcre库,然后安装Nginx:
安装pcre支持rewrite库,也可以安装源码,
注意安装源码时,指定pcre路径解压源码的路径,
而不是编译后的路径,否则报错

cd /usr/src
wget http://nginx.org/download/nginx-1.12.0.tar.gz
tar -zxf nginx-1.12.0.tar.gz
cd nginx-1.12.0

版本隐藏
sed -i -e 's/1.12.0//g' -e 's/nginx\//WS/g' 
-e 's/"NGINX"/"WS"/g' src/core/nginx.h

预编译配置
useradd www;./configure --user=www --group==www --prefix==/usr/local/nginx
--with-http_stub_status_module --with-http_ssl_module

./configure 预编译成功后,执行make命令进行编译
make
make执行成功后,执行make install 正式安装
make install

安装完毕执行测试
/usr/local/nginx/sbin/nginx -t
检查nginx配置文件是否正确
[root@localhost ~]# nginx -t
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful

查看Nginx安装信息

基本信息
nginx -v

详细信息
nginx -V

nginx version: nginx/1.12.0
built by gcc 4.4.7 20120313 (Red Hat 4.4.7-17) (GCC) 
built with OpenSSL 1.0.1e-fips 11 Feb 2013
TLS SNI support enabled
configure arguments: --prefix=/etc/nginx --sbin-path=/usr/sbin/nginx --modules-path=/usr/lib64/nginx/modules --conf-path=/etc/nginx/nginx.conf --error-log-path=/var/log/nginx/error.log --http-log-path=/var/log/nginx/access.log --pid-path=/var/run/nginx.pid --lock-path=/var/run/nginx.lock --http-client-body-temp-path=/var/cache/nginx/client_temp --http-proxy-temp-path=/var/cache/nginx/proxy_temp --http-fastcgi-temp-path=/var/cache/nginx/fastcgi_temp --http-uwsgi-temp-path=/var/cache/nginx/uwsgi_temp --http-scgi-temp-path=/var/cache/nginx/scgi_temp --user=nginx --group=nginx --with-compat --with-file-aio --with-threads --with-http_addition_module --with-http_auth_request_module --with-http_dav_module --with-http_flv_module --with-http_gunzip_module --with-http_gzip_static_module --with-http_mp4_module --with-http_random_index_module --with-http_realip_module --with-http_secure_link_module --with-http_slice_module --with-http_ssl_module --with-http_stub_status_module --with-http_sub_module --with-http_v2_module --with-mail --with-mail_ssl_module --with-stream --with-stream_realip_module --with-stream_ssl_module --with-stream_ssl_preread_module --with-cc-opt='-O2 -g -pipe -Wall -Wp,-D_FORTIFY_SOURCE=2 -fexceptions -fstack-protector --param=ssp-buffer-size=4 -m64 -mtune=generic -fPIC' --with-ld-opt='-Wl,-z,relro -Wl,-z,now -pie'





##Nginx 控制

###nginx启动，停止和重新加载配置
nginx -s 信号

信号:

stop - 快速关机

quit - 正常关机

reload - 重新加载配置文件

reopen - 重新打开日志文件 




##Nginx 配置

        Nginx 的配置主要是修改 /usr/local/nginx/conf/nginx,conf文件

#配置用户和用户组

user www www;

#工作进程数，建议设置为CPU的总核数

worker_processes  2;

#全局错误日志定义类型，日志等级从低到高依次为： debug | info | notice | warn | error | crit

error_log  logs/error.log  info;

#记录主进程ID的文件

pid        /usr/local/nginx/nginx.pid;

#单个进程能打开的文件描述符最大值，理论上该值应该是最多能打开的文件数除以进程数。但是由于nginx负载并不是完全均衡的,所以这个值最好等于最多能打开的文件数。执行 sysctl -a | grep fs.file 可以看到linux文件描述符。

worker_rlimit_nofile 65535;

#工作模式与连接数上限

events {

    #工作模式，linux2.6版本以上用epoll

    use epoll;

    #单个进程允许的最大连接数

    worker_connections  65535;
}

#设定http服务器，利用它的反向代理功能提供负载均衡支持

http {

    #文件扩展名与文件类型映射表

    include       mime.types;

    #默认文件类型

    default_type  application/octet-stream;

    #日志格式

    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                                   '$status $body_bytes_sent "$http_referer" '
                                   '"$http_user_agent" "$http_x_forwarded_for"';

    #access log 记录了哪些用户，哪些页面以及用户浏览器、ip和其他的访问信息

    access_log  logs/access.log  main;

    #服务器名字的hash表大小

    server_names_hash_bucket_size 128;



    #客户端请求头缓冲大小。nginx默认会用client_header_buffer_size这个buffer来读取header值，
    #如果header过大，它会使用large_client_header_buffers来读取。

    #如果设置过小HTTP头/Cookie过大 会报400 错误 nginx 400 bad request
    #如果超过buffer，就会报HTTP 414错误(URI Too Long)
    #nginx接受最长的HTTP头部大小必须比其中一个buffer大，否则就会报400的HTTP错误(Bad Request)。

    client_header_buffer_size 32k;

    large_client_header_buffers 4 32k;

    #客户端请求体的大小

    client_body_buffer_size    8m;

    #隐藏ngnix版本号

    server_tokens off;

    #忽略不合法的请求头

    ignore_invalid_headers   on;

    #指定启用除第一条error_page指令以外其他的error_page。

    recursive_error_pages    on;

    #让 nginx 在处理自己内部重定向时不默认使用  server_name 设置中的第一个域名

    server_name_in_redirect off;

    #开启文件传输，一般应用都应设置为on；若是有下载的应用，则可以设置成off来平衡网络I/O和磁盘的I/O来降低系统负载

    sendfile     on;

    #告诉nginx在一个数据包里发送所有头文件，而不一个接一个的发送。

    tcp_nopush     on;

    #告诉nginx不要缓存数据，而是一段一段的发送--当需要及时发送数据时，就应该给应用设置这个属性，

    #这样发送一小块数据信息时就不能立即得到返回值。

    tcp_nodelay    on;

    #长连接超时时间，单位是秒

    keepalive_timeout  65;

    #gzip模块设置，使用 gzip 压缩可以降低网站带宽消耗，同时提升访问速度。

    gzip  on;             #开启gzip

    gzip_min_length  1k;          #最小压缩大小

    gzip_buffers     4 16k;        #压缩缓冲区

    gzip_http_version 1.0;       #压缩版本

    gzip_comp_level 2;            #压缩等级

    gzip_types       text/plain application/x-javascript text/css application/xml;           #压缩类型

    #upstream作负载均衡，在此配置需要轮询的服务器地址和端口号，max_fails为允许请求失败的次数，默认为1.

    #weight为轮询权重，根据不同的权重分配可以用来平衡服务器的访问率。

    upstream hostname {

        server 192.168.2.149:8080 max_fails=0 weight=1;

        server 192.168.1.9:8080 max_fails=0 weight=1;

    }

    #主机配置

    server {

        #监听端口

        listen       80;

        #域名

        server_name  hostname;
        #字符集
        charset utf-8;
        #单独的access_log文件
        access_log  logs/192.168.2.149.access.log  main;
        #反向代理配置，将所有请求为http://hostname的请求全部转发到upstream中定义的目标服务器中。
        location / {

            #此处配置的域名必须与upstream的域名一致，才能转发。

            proxy_pass     http://hostname;

            proxy_set_header   X-Real-IP $remote_addr;

        }

        #启用nginx status 监听页面

        location /nginxstatus {

            stub_status on;

            access_log on;

        }

        #错误页面

        error_page   500 502 503 504  /50x.html;

        location = /50x.html {

            root   html;
        }

    }

}
