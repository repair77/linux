SOCK5代理服务器
官网: http://ss5.sourceforge.net/


yum -y install gcc gcc-c++ automake make pam-devel openldap-devel cyrus-sasl-devel 
一、安装
wget https://nchc.dl.sourceforge.net/project/ss5/ss5/3.8.9-8/ss5-3.8.9-8.tar.gz
# tar xvf ss5-3.8.9-5.tar.gz
# cd ss5-3.8.9-5
# ./configure && make && make install

二、修改配置文件
1、修改/etc/opt/ss5/ss5.conf 
    yum配置
    cd /etc/opt/ss5.conf
auth      0.0.0.0/0       -         u
permit u        0.0.0.0/0       -       0.0.0.0/0       -       -       -       -       -
2、在/etc/rc.d/init.d/ss5 文件修改自定义端口，默认为1080
daemon /usr/sbin/ss5 -t $SS5_OPTS -b 0.0.0.0:10888
3、在/etc/sysconfig/ss5 中，取消注释。 
SS5_OPTS=” -u root”
4、添加验证用户及密码，由于密码是明文的，注意控制权限。
# cat ss5.passwd   #一行一个用户+密码
test 123
lxsym 123  
# chmod 700 /etc/rc.d/init.d/ss5
# chmod/etc/rc.d/init.d/ss5
[root@lx_web_s1 ss5-3.8.9]# /etc/rc.d/init.d/ss5 restart  
Restarting ss5... Shutting down ss5... 
done                                                       [  OK  ]
doneting ss5...                                            [  OK  ]
服务端安装成功，现在就可以使用服务器的IP, 端口10888, 用户test, 密码123来测试你的socks5服务器了。
最后加入开机自动启动
chkconfig --add ss5
chkconfig --level 345 ss5 on
比如代理上QQ，当ssh跳板机，后面会介绍。它还有很多用途~~













客户端代理软件
http://awy.me/2014/06/yong-shadowsocks-he-proxifier-zi-you-fang-wen-hu-lian-wang/
一、软件介绍

1、什么是Shadowsocks

shadowsocks一个可穿透防火墙的轻量代理，目前已经支持包括WIN，安卓，IOS等所有平台 。 官网地址：http://www.shadowsocks.org/（需梯子） 各版本下载地址：http://shadowsocks.org/en/download/clients.html 目前我使用的是shadowsocks-gui：http://sourceforge.net/projects/shadowsocksgui/files/dist/shadowsocks-gui-0.4-win-ia32.7z

2、什么是Proxifier

Proxifier是一款功能非常强大的socks5客户端，可以让不支持通过代理服务器工作的网络程序能通过HTTPS或SOCKS代理或代理链。支持 64位系统，支持Xp，Vista，Win7，MAC OS ,支持socks4，socks5，http代理协议，支持TCP，UDP协议，可以指定端口，指定IP，指定域名,指定程序等运行模式，兼容性非常好，和SOCKSCAP属于同类软件，不过SOCKSCAP已经很久没更新了，不支持64位系统。 有许多网络应用程序不支持通过代理服务器工作，Proxifier 解决了这些问题和所有限制，让您有机会不受任何限制使用你喜爱的软件。此外，它让你获得了额外的网络安全控制，创建代理隧道，并添加使用更多网络功能的权力。

Proxifier 使您可以：

1、通过代理服务器运行任何网络应用程序。对于软件不需要有什么特殊配置；整个过程是完全透明的。
2、通过代理服务器网关访问受限制的网络。
3、绕过防火墙的限制。
4、”隧道”整个系统 （强制所有网络连接，包括系统工作都通过代理服务器连接）。
5、通过代理服务器解析 DNS 名称。
6、灵活的代理规则，对于主机名和应用程序名称可使用通配符。
7、通过隐藏您的 IP 地址的获得安全隐私。
8、通过代理服务器链来工作，可使用不同的协议。
9、查看当前网络活动的实时信息（连接，主机，时间，带宽使用等）。
10、维护日志文件和流量转储。
11、获得详细的网络错误报告。
官网地址：https://www.proxifier.com/
下载地址：https://www.proxifier.com/download.htm

此软件为收费软件，不过这里提供几个注册码，直接安装注册即可,软件分为Standard Edition和Portable Edition版本，注册码不通用，注册用户名任意。 L6Z8A-XY2J4-BTZ3P-ZZ7DF-A2Q9C（Portable Edition） 5EZ8G-C3WL5-B56YG-SCXM9-6QZAP（Standard Edition）