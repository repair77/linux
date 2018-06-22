linux系统目录介绍
01.bin 可执行文件(常用可执行命令)
02.boot (引导启动目录) vmlinux内核 grub
03.dev 设备目录 (硬盘/网卡/声卡)
04.etc 配置文件
05.home 所有用户的家目录 root单独
06.lib 库文件
07.media 挂载，~~mnt
08.opt 大型software install
09.proc 系统的一些实时信息，是虚拟文件夹，存在内存中虚拟数据keep current info/acpi 电源信息
10.sys
11.tmp 临时文件
12.usr 应用软件
13.var 经常变化的信息(eg:OS log)



任何公共访问的内容，都需要放在在html目录下，且设置合适权限
目录的合适权限通常是701或711,而php文件通常是600
而另外几乎所有的文件,比如css/imgages和非动态的html,即静态文件都应该是644

关于端口
通常0-1023端口保留
1024-65000都可以随便供你选择

关于服务器DNS记录
通常foo.com必须是 A记录,要映射到特定IP
www.foo.com 也可以成为A记录映射到相同IP,
或者让他成为CNAME记录,映射到互联网上的任意域名,通常@符表示根域名

uptime 查看负载

top 查看cou运行

free -k 查看内存

ps -ef 查看进程

pstree 查看进程数

df -k 查看硬盘信息




CentOS 安装设置与命令

# 配置国内yum源
mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
cd /etc/yum.repos.d/
wget http://mirrors.163.com/.help/CentOS6-Base-163.repo
yum clean all
yum makecache



二、设置IP地址、网关、DNS

Linux 网卡配置（一）网卡配置文件
（ 1 ） /etc/sysconfig/network-scripts/ifcfg-interface-name
配置文件 ifcfg-interface-name 包含了初始化接口所需的大部分详细信息。其中 interface-name 将根据网卡的类型和排序而不同，一般其名字为 eth0 、 eth1 、 ppp0 等，其中 eth 表示以太（ eth0 ）类型网卡， 0 表示第一块网卡， 1 表示第二块网卡，而 ppp0 则表示第一个 point-to-poirt protocol 网络接口。在 ifcfg 文件中定义的各项目取决于接口类型。下面的值较问常见：
》 DEVICE=name ，其中， name 是物理设备名。
》 IPADDR=addr ，其中， addr 是 IP 地址。
》 NETMASK=mask ，其中， mask 是网络掩码值。
》 NETWORK=addr ，其中 addr 是网络地址。
》 BROADCAST=addr ，其中， addr 是广播地址。
》 GATEWAY=addr ，其中 addr 是网关地址。
》 ONBOOT=answer ，其中， answer 是 yes （引导时激活设备）或 no （引导时不激活设备）
》 USERCTL=answer ，其中， answer 是 yes （非 root 用户可以控制该设备）或 no
》 BOOTPROTO=proto ，其中， proto 取下列值之一： none ，引导时不使用协议； static 静态分配地址； bootp ，使用 BOOTP 协议，或 dhcp ，使用 DHCP 协议

(3) 参数配置完毕后保存文件，并使用 /etc/init.d/network restart 命令重启网络设备，最新设值即可生效


说明：CentOS 6.8默认安装好之后是没有自动开启网络连接的！

输入账号root

再输入安装过程中设置的密码，登录到系统

vi  /etc/sysconfig/network-scripts/ifcfg-eth0   #编辑配置文件,添加修改以下内容

BOOTPROTO=static   #启用静态IP地址

ONBOOT=yes  #开启自动启用网络连接

IPADDR=192.168.21.129  #设置IP地址

NETMASK=255.255.255.0  #设置子网掩码

GATEWAY=192.168.21.2   #设置网关

DNS1=8.8.8.8 #设置主DNS

DNS2=8.8.4.4 #设置备DNS

IPV6INIT=no  #禁止IPV6
00:0C:29:D7:ED:8A
:wq!  #保存退出

service ip6tables stop   #停止IPV6服务

chkconfig ip6tables off  #禁止IPV6开机启动

service yum-updatesd stop   #关闭系统自动更新

chkconfig yum-updatesd off  #禁止开启启动

service network restart  #重启网络连接

ifconfig  #查看IP地址

三、设置主机名

约定：

主机名命名规范：业务.机房.主备.域名

这里设置主机名为：bbs.hz.m.osyunwei.com

1、hostname “bbs.hz.m.osyunwei.com”

#设置主机名为bbs.hz.m.osyunwei.com

2、vi /etc/sysconfig/network  #编辑配置文件

HOSTNAME= bbs.hz.m.osyunwei.com

#修改localhost.localdomain为bbs.hz.m.osyunwei.com

:wq!  #保存退出

更改hostname
echo test-websocket > /proc/sys/kernel/hostname

3、vi /etc/hosts #编辑配置文件

127.0.0.1  bbs.hz.m.osyunwei.com localhost

#修改localhost.localdomain为bbs.hz.m.osyunwei.com

:wq!  #保存退出

shutdown -r now  #重启系统




创建,删除文件

通过touch命令可以创建一个空文件或更新文件时间

通过rm命令可以删除文件或目录
常用参数
-i 交互式
-r 递归的删除包括目录中的所有内容
-f 强制删除,没有警告提示

创建删除目录
通过 mkdir命令创建一个目录
通过 rmdir命令删除一个空目录
通过 rm -r 命令删除一个非空目录

日期时间

// 修正时区
ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime 
// 设置时间
date –s '2012-02-13 12:38:10' 
clock –w // 将时间写入CMOS
然后用reboot重启VPS,再去看看系统时间

格林尼治时间
date -u

格式化输出
date +%Y--%m--%d
2017--04--17

设置时间(root)
date -s "21:34:34"

命令hwclock(clock) 显示硬件时钟时间

命令cal用以查看日历

命令uptime用以查看系统运行时间


查找
find / -name 'vmware-uninstall-tools.p'


命令man
q退出


tar 解压缩命令详解

-c: 建立压缩档案
-x：解压
-t：查看内容
-r：向压缩归档文件末尾追加文件
-u：更新原压缩包中的文件
这五个是独立的命令，压缩解压都要用到其中一个，可以和别的命令连用但只能用其中一个。下面的参数是根据需要在压缩或解压档案时可选的。
-z：有gzip属性的
-j：有bz2属性的
-Z：有compress属性的
-v：显示所有过程
-O：将文件解开到标准输出
-f: 使用档案名字，切记，这个参数是最后一个参数，后面只能接档案名。

解压与压缩
#目录
/usr/local/test

压缩操作
# tar -cvf ./test.tar /usr/local/test 仅打包目录，不压缩 
# tar -zcvf ./test.tar.gz /usr/local/test 打包后，以gzip压缩 在参数f后面的压缩文件名是自己取的，习惯上用tar来做，如果加z参数，则以tar.gz 或tgz来代表gzip压缩过的tar file文件

解压操作:
#tar -zxvf /usr/local/test.tar.gz


下面的参数-f是必须的
# tar -cf all.tar *.jpg 
将所有.jpg的文件打成一个名为all.tar的包。-c是表示产生新的包，-f指定包的文件名。

# tar -rf all.tar *.gif 
将所有.gif的文件增加到all.tar的包里面去。-r是表示增加文件的意思。

# tar -uf all.tar logo.gif 
更新原来tar包all.tar中logo.gif文件，-u是表示更新文件的意思。

# tar -tf all.tar 
列出all.tar包中所有文件，-t是列出文件的意思

# tar -xf all.tar 
解出all.tar包中所有文件，-x是解开的意思

压缩
---tar.gz
将目录里所有jpg文件打包成jpg.tar后，并且将其用gzip压缩，生成一  个gzip压缩过的包，命名为jpg.tar.gz
tar –cvf jpg.tar *.jpg //将目录里所有jpg文件打包成jpg.tar
tar –czf jpg.tar.gz *.jpg   //

---tar.bz2
tar –cjf jpg.tar.bz2 *.jpg //将目录里所有jpg文件打包成jpg.tar后，并且将其用bzip2压缩，生成一个bzip2压缩过的包，命名为jpg.tar.bz2
tar –cZf jpg.tar.Z *.jpg   //将目录里所有jpg文件打包成jpg.tar后，并且将其用compress压缩，生成一个umcompress压缩过的包，命名为jpg.tar.Z

---rar
rar a jpg.rar *.jpg //rar格式的压缩，需要先下载rar for linux
zip jpg.zip *.jpg //zip格式的压缩，需要先下载zip for linux

解压
tar –xvf file.tar //解压 tar包
tar -xzvf file.tar.gz //解压tar.gz
tar -xjvf file.tar.bz2   //解压 tar.bz2
tar –xZvf file.tar.Z   //解压tar.Z
unrar e file.rar //解压rar
unzip file.zip //解压zip
zip 命令： 
# zip test.zip test.txt 
它会将 test.txt 文件压缩为 test.zip ，当然也可以指定压缩包的目录，例如 /root/test.zip 

# unzip test.zip 
它会默认将文件解压到当前目录，如果要解压到指定目录，可以加上 -d 选项 

总结
  (1)、*.tar 用 tar –xvf 解压
  (2)、*.gz 用 gzip -d或者gunzip 解压
  (3)、*.tar.gz和*.tgz 用 tar –xzf 解压
  (4)、*.bz2 用 bzip2 -d或者用bunzip2 解压
  (5)、*.tar.bz2用tar –xjf 解压
  (6)、*.Z 用 uncompress 解压
  (7)、*.tar.Z 用tar –xZf 解压
  (8)、*.rar 用 unrar e解压
  (9)、*.zip 用 unzip 解压


#用RPM安装软件包
rpm -i example.rpm 安装 example.rpm 包；
rpm -iv example.rpm 安装 example.rpm 包并在安装过程中显示正在安装的文件信息；
rpm -ivh example.rpm 安装 example.rpm 包并在安装过程中显示正在安装的文件信息及安装进度

删除已安装的软件包
rpm -e example

查询软件包
rpm -q example

查询vim命令的安装包
rpm -qf /usr/bin/vim


###############
   系统管理
###############

磁盘管理
df： 显示每个文件驻留的文件系统的信息，或默认的所有文件系统。
包括文件系统、已使用、未使用、已使用空间的占用百分比和挂载点等信息
df -h


ps命令
ps命令用来查看当前系统中运行的进程的信息。
可以根据显示的信息确定哪个进程正在运行，
哪个进程是被挂起或出了问题，进程已运行了多久，进程正在使用的资源，
进程的相对优先级及进程的标志号（PID）。
常用选项：
-a  显示系统中与tty相关的（除会话组长之外）所有进程的信息。
-e  显示所有进程的信息。
-f  显示进程的所有信息。
-l  以长格式显示进程信息。
-r  只显示正在运行的进程。
-u  显示面向用户的格式（包括用户名、CPU及内存使用情况等信息）。
-x  显示所有终端上的进程信息。

加入alias
vi ~/.bashrc
alias vi='vim --color=auto'
alias rm='rm -i --color=auto'
生效
source ~/.bashrc

显示终端中包括其它用户的所有进程
ps a

示例：
①列出每个与当前Shell有关的进程的基本信息：
#ps
  PID TTY          time CMD
 9723 pts/0    00:00:00 bash
 9751 pts/0    00:00:00 ps

其中，各字段的含义如下：
PID  进程标志号。
TTY  该进程建立时所对应的终端，“？”表示该进程不占用终端。
TIME  报告进程累计使用的CPU时间。注意，尽管有些命令（如 sh）已经运转了很长时间，但是它们真正使用CPU的时间往往很短。所以，该字段的值往往是00:00:00。
CMD 执行进程的命令名。

 ②显示系统中所有进程的全面信息：
# ps -ef
UID        PID  PPID  C STIME TTY          TIME CMD
root         1     0  0 Jun25 ?        00:00:01 init [3]                   
root         2     1  0 Jun25 ?        00:00:00 [migration/0]
root         3     1  0 Jun25 ?        00:00:00 [ksoftirqd/0]
root         4     1  0 Jun25 ?        00:00:00 [watchdog/0]
root         5     1  0 Jun25 ?        00:00:00 [migration/1]
root         6     1  0 Jun25 ?        00:00:00 [ksoftirqd/1]
root         7     1  0 Jun25 ?        00:00:00 [watchdog/1]
root         8     1  0 Jun25 ?        00:00:00 [events/0]
root         9     1  0 Jun25 ?        00:00:00 [events/1]
root        10     1  0 Jun25 ?        00:00:00 [khelper]
……
root      9755  9723  0 10:10 pts/0    00:00:00 ps -ef
各项的含义是：
UID  进程属主的用户ID号。
PID  进程ID号。
PPID  父进程的ID号。
C  进程最近使用CPU的估算。
STIME  进程开始时间，以小时:分:秒的形式给出。
TTY  该进程建立时所对应的终端，“？”表示该进程不占用终端。
TIME  报告进程累计使用的CPU时间。注意，尽管有些命令（如 sh）己经运转了很长时间，但是它们真正使用CPU的时间往往很短。所以，该字段的值往往是0:00。
CMD 是conunand（命令）的缩写。

③显示所有终端上所有用户的有关进程的所有信息：
# ps -aux
USER       PID %CPU %MEM    VSZ   RSS TTY      stat START   TIME command
root         1  0.0  0.0   2160   660 ?        ss   Jun25   0:01 init [3]                   
root         2  0.0  0.0      0     0 ?        S<   Jun25   0:00 [migration/0]
root         3  0.0  0.0      0     0 ?        SN   Jun25   0:00 [ksoftirqd/0]
root         4  0.0  0.0      0     0 ?        S<   Jun25   0:00 [watchdog/0]
root         5  0.0  0.0      0     0 ?        S<   Jun25   0:00 [migration/1]
root         6  0.0  0.0      0     0 ?        SN   Jun25   0:00 [ksoftirqd/1]
root         7  0.0  0.0      0     0 ?        S<   Jun25   0:00 [watchdog/1]
root         8  0.0  0.0      0     0 ?        S<   Jun25   0:00 [events/0]
root         9  0.0  0.0      0     0 ?        S<   Jun25   0:00 [events/1]
root        10  0.0  0.0      0     0 ?        S<   Jun25   0:00 [khelper]
root        11  0.0  0.0      0     0 ?        S<   Jun25   0:00 [kthread]
root        15  0.0  0.0      0     0 ?        S<   Jun25   0:00 [kblockd/0]
root        16  0.0  0.0      0     0 ?        S<   Jun25   0:00 [kblockd/1]
root        17  0.0  0.0      0     0 ?        S<   Jun25   0:00 [kacpid]
root       120  0.0  0.0      0     0 ?        S<   Jun25   0:00 [cqueue/0]
……
root      9784  0.0  0.0   5456   956 pts/0    R+   10:23   0:00 ps -aux


USER  启动进程的用户。
%CPU  运行该进程占用CPU的时间与该进程总的运行时间的比例。
%MEM  该进程占用内存和总内存的比例。
VSZ  虚拟内存的大小，以KB为．单位。
RSS  占用实际内存的大小，以KB为单位。
STAT  进程的运行状态，其中包括以下几种代码：
　D 不可中断的睡眠。
　R 执行。
　S 睡眠。
　T 跟踪或停止。
　Z 终止。
　w 没有内存驻留页。
　< 高优先权的进程。
　N 低优先权的进程。
　L 有锁入内存的页面（用于实时任务或UO任务）。
START  开始运行的时间。


kill命令
kill命令用来终止一个进程的运行。
通常，终止一个前台进程可以使用Ctrl+C键，
但是，对于一个后台进程就须用kill命令来终止。
kill命令是通过向进程发送指定的信号来结束相应进程的。
在默认情况下，采用编号为15的TERM信号。
TERM信号将终止所有不能捕获该信号的进程。
对于那些可以捕获该信号的进程就要用编号为9的kill信号，强行“杀掉”该进程。
一般格式：
kill [-s 信号 -p] [-a] 进程号…
kill -l [信号]

选项：
-s 指定需要发送的信号，既可以是信号名（如kill)，也可以是对应信号的号码（如9）。
-p 指定kill命令只是显示进程的PID（进程标志号），并不真正发出结束信号。
-l 显示信号名称列表，这也可以在/usr/include/linux/signal.h文件中找到。

注意：
1、kill命令可以带信号号码选项，也可以不带。如果没有信号号码，kin命令就会发出终止信号（15)，这个信号可以被进程捕获，使得进程在退出之前可以清理并释放资源。也可以用kiU向进程发送特定的信号。例如：
kill -2 123
它的效果等同于在前台运行PID为123的进程时按下Ctrl+C键。但是，普通用户只能使用不带signal参数的kill命令或最多使用-9信号。

2、kill可以带有进程ID号作为参数。当用kill向这些进程发送信号时，必须是这些进程的主人。如果试图撤销一个没有权限撤销的进程或撤销一个不存在的进程，就会得到一个错误信息。

3、可以向多个进程发信号或终止它们。

4、当kill成功地发送了信号后，shell会在屏幕上显示出进程的终止信息。有时这个信息不会马上显示，只有当按下Enter键使shell的命令提示符再次出现时，才会显示出来。

5、应注意，信号使进程强行终止，这常会带来一些副作用，如数据丢失或者终端无法恢复到正常状态。发送信号时必须小心，只有在万不得已时，才用kill信号（9)，因为进程不能首先捕获它。要撤销所有的后台作业，可以输入kill 0。因为有些在后台运行的命令会启动多个进程，跟踪并找到所有要杀掉的进程的PID是件很麻烦的事。这时，使用kill 0来终止所有由当前shell启动的进程，是个有效的方法。

示例：
一般可以用kill命令来终止一个己经挂死的进程或者一个陷入死循环的进程。首先执行以下命令：
# find / -name core -print>/dev/null 2>&1&
这是一条后台命令，执行时间较一长。其功能是：从根目录开始搜索名为core的文件，将结果输出（包括错误输出）都定向到/dev/null文件。现在决定终止该进程。为此，运行ps命令来查看该进程对应的PID。例如，该进程对应的PID是1651，现在可用垃l命令“杀死”这个进程：
#kill 1651
再用ps命令查看进程状态时，就可以看到，find进程已经不存在了。

sleep命令
sleep命令的功能是使进程暂停执行一段时间。“时间值”参数以秒为单位，即让进程暂停由时间值所指定的秒数。此命令大多用于shell程序设计中，使两条命令执行之间停顿指定的时间。

一般格式：sleep 时间值

示例：下面的命令行使进程先暂停100秒，然后查看用户abc是否在系统中：
#sleep 100;who | grep 'abc'

  tour



程序后台运行 




redis-server &



CentOS 6.8 


#################
#Nginx(官方)
#################

yum安装(自动解决依赖)



设置yum安装源
touch /etc/yum.repos.d/nginx.repo
粘贴以下内容

[nginx]
name=nginx repo
baseurl=http://nginx.org/packages/centos/6/$basearch/
gpgcheck=0
enabled=1

然后
获取签名文件,导入签名文件
wget http://nginx.org/keys/nginx_signing.key
rpm --import nginx_signing.key
修改gpgcheck为1

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

显示上面就证明ok了

7.Nginx 控制 (启动，停止和重新加载配置)

  nginx -s 信号
  信号:
  stop - 快速关机
  quit - 正常关机
  reload - 重新加载配置文件
  reopen - 重新打开日志文件 


证书转换

openssl x509 -in 1_linkbitc.bicoin.com.cn_bundle.crt -out 1_linkbitc.bicoin.com.cn_bundle.cer -outform der

#################
#MySQL(官方)
#################

#yum安装mysql

#更改mysql官方源(好慢)
wget https://repo.mysql.com//mysql57-community-release-el6-11.noarch.rpm
wget https://repo.mysql.com/mysql57-community-release-el7.rpm

sudo rpm -Uvh mysql57-community-release-el6-11.noarch.rpm


----------------------------------------------------------------------------
官方文档
wget https://dev.mysql.com/get/mysql80-community-release-el7-1.noarch.rpm
yum localinstall mysql80-community-release-el7-1.noarch.rpm

#检查repo源
yum repolist all | grep mysql

#配置版本
sudo vi /etc/yum.repos.d/mysql-community.repo
例如，要安装MySQL 5.6,
设置MySQL5.6 下的子项enabled=1
设置MySQL5.7下的子项 enabled=0，

例如:
[mysql57-community]
name=MySQL 5.7 Community Server
baseurl=http://repo.mysql.com/yum/mysql-5.7-community/el/6/$basearch/
enabled=1
gpgcheck=1
gpgkey=file:///etc/pki/rpm-gpg/RPM-GPG-KEY-mysql

#安装
yum install mysql-community-server

#启动mysqld作为系统服务
service mysqld start

#查看mysqld服务状态
service mysqld status

----------------------------------------------------------------------------

配置版本
sudo nano /etc/yum.repos.d/mysql-community.repo
例如，要安装MySQL 5.6,
设置MySQL5.6 下的子项enabled=1
设置MySQL5.7下的子项 enabled=0，
例如:
[mysql57-community]
name=MySQL 5.7 Community Server
baseurl=http://repo.mysql.com/yum/mysql-5.7-community/el/6/$basearch/
enabled=1
gpgcheck=1
gpgkey=file:///etc/pki/rpm-gpg/RPM-GPG-KEY-mysql


1. 安装

  sudo yum install mysql-community-server

2. 配置

  vim /etc/my.cnf 

3. 启动mysql,查看mysql服务状态

  service mysqld status
  service mysqld start
  或者
  /etc/init.d/mysqld start
  /etc/init.d/mysqld stop

4. 查看进程,

  ps aux|grep mysqld
  ps -ef | grep mysqld

5. 查看MySQL版本
  
  mysql --version


6. 更改mysql密码(5.6)

  命令方式
  mysqladmin root password 'new_password'

  SQL方式
  ----设置当前用户的密码
  SELECT USER();
  set password=password('sss');
  set password=password('');

  SET PASSWORD FOR `root`@`localhost` = PASSWORD('your_password')
-----------------------------------------------------------------------
  mysql--5.7


  --安装启动后超级用户帐户'root'@'localhost已创建
  --超级用户的密码被设置并存储在错误日志文件中。要显示它，请使用以下命令：
  --查看密码
  grep 'temporary PASSWORD' /var/log/mysqld.log

  --使用临时密码登陆
  mysql -uroot -p

  --修改密码
  ALTER USER 'root'@'localhost' IDENTIFIED BY 'MyNewPass4!';

  --忘记密码?
  1、修改/etc/my.cnf，在 [mysqld] 小节下添加一行：skip-grant-tables=1

      这一行配置让 mysqld 启动时不对密码进行验证

  2、重启mysqld 服务：systemctl restart mysqld

  3、使用 root 用户登录到 mysql：mysql -uroot 

  4、切换到mysql数据库，更新 user 表：

  update user set authentication_string = password('123456'),password_expired = 'N', password_last_changed = now() where user = 'root';


7. 查看mysql的安装位置 
  whereis mysql
  which mysql

validate_password 是默认安装的。实施的默认密码策略validate_password要求密码至少包含一个大写字母，一个小写字母，一个数字和一个特殊字符，并且总密码长度至少为8个字符。


PHP与PHP-FPM


yum源的配置文件位于 /etc/yum.repos.d/下
CentOS 6 建议加装下面
rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
rpm -ivh http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm

安装好后可以查看以下remi的php和mysql版本,都提供有5.5版,
但php5.5由remi-test提供,生产环境请慎用:
yum --enablerepo=remi list php
remi-test和remi源默认是不开启的,
需要通过--enablerepo参数指定,把/etc/yum.repos.d/remi.repo里对应的[remi]和[remi-test]块下的enabled=0改为enabled=1则为默认开启.



安装PHP5.6
yum --enablerepo=remi install php56

如果您需要安装其他PHP模块，如mbstring，mcrypt，soap，apc，则可以使用以下命令。
＃yum list php56*  //查看所有php56的扩展

yum install php56-php-fpm php56-php-gd php56-php-mbstring php56-php-mcrypt php56-php-soap php56-php-apc php56-php-mysqlnd -y

yum list | grep php

＃yum groupinstall“PHP Support”--enablerepo = remi-php56  - y
yum --enablerepo=remi remove php-mbstring php-mcrypt php-soap php-apc php-mysqlnd -y

查看PHP安装模块
php -m
php56 -m(remi版本)
ini配置信息
php --ini
PHP配置文件php.ini路径： /etc/php.ini


#################
配置nginx支持php
#################

1. 修改nginx目录

nano /etc/nginx/conf.d/default.conf
location /{
    root /var/www;
    index index.php index.html index.htm;
}

2. 配置php支持

# pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
#
location ~ \.php$ {
        root           html;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  /var/www$fastcgi_script_name;
        include        fastcgi_params;
}

3. 配置php-fpm支持

php-fpm配置文件php-fpm.conf路径：/etc/php-fpm.conf
php-fpm配置 nano /etc/php-fpm.d/www.conf
/opt/remi/php56/root/etc/php-fpm.conf

; RPM: apache Choosed to be able to access some dir as httpd
user = nginx
; RPM: Keep a group allowed to write in log dir.
group = nginx



php-fpm 启动,重启,停止,状态,重载配置

# /etc/init.d/php-fpm -[start|restart|stop|status|reload]

测试php-fpm 
php-fpm -t


<!-- 创建符号链接 -->

ln用来为文件创建连接,默认是 硬连接
连接类型分为 硬连接 和 符号(symbol)连接 两种，
如果要创建 符号连接 必须使用"-s"选项。

创建php-fpm 软连接(符号链接)
cd /usr/bin
ln -s /opt/remi/php56/root/usr/sbin/php-fpm php-fpm
符号链接文件不是一个独立的文件，
它的许多属性依赖于源文件，
所以给符号链接文件设置存取权限是没有意义的




<!-- 配置为系统服务后 -->

chkconfig --list        #列出所有的系统服务
chkconfig --add php-fpm        #增加php-fpm为系统服务
chkconfig php-fpm on   #运行在2345上

#启动服务
service php-fpm start
#重启服务
service php-fpm restart


<!-- 编译安装php5.6(较难) -->


下载php5.6
cd /usr/local/src
wget http://hk2.php.net/distributions/php-5.6.31.tar.gz;
解压安装包
tar zxvf php-5.6.31.tar.gz

<!-- 安装依赖包 -->
yum -y install gcc gcc-c++ libxml2 libxml2-devel libcurl-devel openssl openssl-devel mcrypt libmcrypt libmcrypt-devel libiconv libjpeg-devel libpng-devel freetype-devel bzip2 bzip2-devel


<!-- 预编译 -->
./configure --prefix=/usr/local --with-config-file-path=/etc --with-config-file-scan-dir=/etc/php.d --with-mysql=mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --with-pcre-regex --with-iconv --with-zlib --with-gd --with-openssl --with-xmlrpc --with-curl --with-imap-ssl --with-freetype-dir --enable-fpm --enable-pcntl --with-mcrypt --with-mhash --with-gettext --with-bz2 --without-pear --disable-phar --enable-mysqlnd --enable-opcache --enable-sockets --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-shmop --enable-zip --enable-ftp --enable-soap --enable-xml --enable-mbstring --disable-rpath --disable-debug --disable-fileinfo 


--prefix=usr/local \
--with-config-file-path=/etc \
--with-config-file-scan-dir=/etc/php.d \



<!-- 编译安装 -->
<!--  # make && make install  -->
// 编译安装完成之后,需要从解压后的文件夹中把php.ini-development 
// 或是 php.ini-production 重命名成php.ini 复制到php安装文件中的相应位置,
// 可在phpinfo中查看 相应位置.
// 把/usr/local/php/etc/php-fpm.conf.default  复制到当前文件夹下,命名为php-fpm.conf


开启php-fpm并设置开机启动

复制php-fpm启动脚本到/etc/init.d
<!-- 源码安装目录 -->
cp /usr/local/src/php-5.6.31/sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm

赋予执行权限
chmod +x /etc/init.d/php-fpm

加入系统启动项列表
chkconfig --add php-fpm

设置启动级别(默认2 3 4 5 启动) 
chkconfig php-fpm on

启动php-fpm
service php-fpm start
或者
/etc/init.d/php-fpm start






单独PHP安装扩展

wget http://pecl.php.net/get/redis-3.1.3.tgz
phpize
<!-- 配置redis扩展和php结合 -->
./configure --with-php-config=/usr/local/bin/php-config
<!-- 编译和安装 -->
make && make install
<!-- 成功后提示安装在哪里了 -->
Installing shared extensions: /usr/local/lib/php/extensions/no-debug-non-zts-20131226/

<!-- 修改php.ini配置的扩展文件夹 -->
vim /etc/php.ini
把
extension_dir="./"
改为你的php扩展安装的目录

具体可搜索 

find /usr/local/lib/php -name '*.so'

加载扩展
extension=redis.so
重启php-fpm查看即可
/etc/init.d/php-fpm restart


2.给PHP添加动态扩展
/usr/local/bin/phpize
./configure --with-php-config=/usr/local/bin/php-config
make
make install








#配置系统服务 chkconfig
Linux下chkconfig命令详解

设置开机启动

使用范例：
chkconfig --list        #列出所有的系统服务
chkconfig --add httpd        #增加httpd服务
chkconfig --del httpd        #删除httpd服务
chkconfig --level httpd 2345 on        #设置httpd在运行级别为2、3、4、5的情况下都是on（开启）的状态
chkconfig --list        #列出系统所有的服务启动情况
chkconfig --list mysqld        #列出mysqld服务设置情况
chkconfig --level 35 mysqld on        #设定mysqld在等级3和5为开机运行服务，--level 35表示操作只在等级3和5执行，on表示启动，off表示关闭

chkconfig mysqld on        #设定mysqld在各等级为on，“各等级”包括2、3、4、5等级

如何增加一个服务：
1.服务脚本必须存放在/etc/ini.d/目录下；
2.chkconfig --add servicename
    在chkconfig工具服务列表中增加此服务，此时服务会被在/etc/rc.d/rcN.d中赋予K/S入口了；
3.chkconfig --level 35 mysqld on
    修改服务的默认启动等级。




chkconfig命令主要用来更新（启动或停止）和查询系统服务的运行级信息。
谨记chkconfig不是立即自动禁止或激活一个服务，它只是简单的改变了符号连接。

使用语法：
chkconfig [--add][--del][--list][系统服务] 或 chkconfig [--level <等级代号>][系统服务][on/off/reset]

chkconfig在没有参数运行时，显示用法。
如果加上服务名，那么就检查这个服务是否在当前运行级启动。
如果是，返回true，否则返回false。
如果在服务名后面指定了on，off或者reset，
那么chkconfig 会改变指定服务的启动信息。
on和off分别指服务被启动和停止，reset指重置服务的启动信息，无论有问题的初始化脚本指定了什么。
on和off开关，系统默认只对运行级3，4，5有效，但是reset可以对所有运行级有效。

参数用法：
   --add 　增加所指定的系统服务，让chkconfig指令得以管理它，并同时在系统启动的叙述文件内增加相关数据。
   --del 　删除所指定的系统服务，不再由chkconfig指令管理，并同时在系统启动的叙述文件内删除相关数据。
   --level<等级代号> 　指定读系统服务要在哪一个执行等级中开启或关毕。
      等级0表示：表示关机
      等级1表示：单用户模式
      等级2表示：无网络连接的多用户命令行模式
      等级3表示：有网络连接的多用户命令行模式
      等级4表示：不可用
      等级5表示：带图形界面的多用户模式
      等级6表示：重新启动
      需要说明的是，level选项可以指定要查看的运行级而不一定是当前运行级。对于每个运行级，只能有一个启动脚本或者停止脚本。当切换运行级时，init不会重新启动已经启动的服务，也不会再次去停止已经停止的服务。

    chkconfig --list [name]：显示所有运行级系统服务的运行状态信息（on或off）。如果指定了name，那么只显示指定的服务在不同运行级的状态。
    chkconfig --add name：增加一项新的服务。chkconfig确保每个运行级有一项启动(S)或者杀死(K)入口。如有缺少，则会从缺省的init脚本自动建立。
    chkconfig --del name：删除服务，并把相关符号连接从/etc/rc[0-6].d删除。
    chkconfig [--level levels] name：设置某一服务在指定的运行级是被启动，停止还是重置。

运行级文件：
每个被chkconfig管理的服务需要在对应的init.d下的脚本加上两行或者更多行的注释。

第一行告诉chkconfig默认启动的运行级以及启动和停止的优先级。
如果某服务缺省不在任何运行级启动，那么使用 - 代替运行级。

第二行对服务进行描述，可以用\ 跨行注释。

例如，random.init包含三行：
# chkconfig: 2345 20 80
# description: Saves and restores system entropy pool for \
# higher quality random number generation.



netstat命令详解
http://www.cnblogs.com/ggjucheng/archive/2012/01/08/2316661.html

Netstat 命令用于显示各种网络相关信息，
如网络连接，路由表，接口状态 (Interface Statistics)，masquerade 连接，多播成员 (Multicast Memberships) 等等。

执行netstat后，其输出结果
分为两个部分
一个是Active Internet connections，称为有源TCP连接，
  
  其中"Recv-Q"和"Send-Q"指%0A的是接收队列和发送队列。
  这些数字一般都应该是0。
  如果不是则表示软件包正在队列中堆积。
  这种情况只能在非常少的情况见到。

另一个是Active UNIX domain sockets，称为有源Unix域套接口
(和网络套接字一样，但是只能用于本机通信，性能可以提高一倍)
  
  Proto显示连接使用的协议,
  RefCnt表示连接到本套接口上的进程号,
  Types显示套接口的类型,
  State显示套接口当前的状态,
  Path表示连接到套接口的其它进程使用的路径名。

常见参数
-a (all)显示所有选项，默认不显示LISTEN相关
-t (tcp)仅显示tcp相关选项
-u (udp)仅显示udp相关选项
-n 拒绝显示别名，能显示数字的全部转化成数字。
-l 仅列出有在 Listen (监听) 的服務状态
-i 显示网络接口列表

-p 显示建立相关链接的程序名
-r 显示路由信息，路由表
-e 显示扩展信息，例如uid等
-s 按各个协议进行统计
-c 每隔一个固定时间，执行该netstat命令。

提示：LISTEN和LISTENING的状态只有用-a或者-l才能看到


使用命令实例
1. 列出所有端口 (包括监听和未监听的)
列出所有端口 netstat -a | more
列出所有 tcp 端口 netstat -at
列出所有 udp 端口 netstat -au

2. 列出所有处于监听状态的 Sockets
只显示监听端口 netstat -l
只列出所有监听 tcp 端口 netstat -lt
只列出所有监听 udp 端口 netstat -lu
只列出所有监听 UNIX 端口 netstat -lx

3. 显示每个协议的统计信息
显示所有端口的统计信息 netstat -s
显示 TCP 或 UDP 端口的统计信息 netstat -st 或 -su

4. 在 netstat 输出中显示 PID 和进程名称 netstat -p
netstat -p 可以与其它开关一起使用，
就可以添加 “PID/进程名称” 到 netstat 输出中，
这样 debugging 的时候可以很方便的发现特定端口运行的程序。

5. 在 netstat 输出中不显示主机，端口和用户名 (host, port or user)
当你不想让主机，端口和用户名显示，
使用 netstat -n。将会使用数字代替那些名称
同样可以加速输出，因为不用进行比对查询。

6. 持续输出 netstat 信息
将每隔一秒输出网络信息 netstat-c 

7. 显示系统不支持的地址族 (Address Families)
netstat --verbose

8. 显示核心路由信息 netstat -r

9. 找出程序运行的端口
并不是所有的进程都能找到，没有权限的会不显示，
使用 root 权限查看所有的信息。
netstat -ap | grep ssh

找出运行在指定端口的进程
netstat -an | grep ':80'

10. 显示网络接口列表
netstat -i

11. IP和TCP分析
  查看连接某服务端口最多的的IP地址
netstat -nat | grep "192.168.1.15:22" |awk '{print $5}'|awk -F: '{print $1}'|sort|uniq -c|sort -nr|head -20

TCP各种状态列表
netstat -nat |awk '{print $6}'

先把状态全都取出来,然后使用uniq -c统计，之后再进行排序。
netstat -nat |awk '{print $6}'|sort|uniq -c
最后的命令如下
netstat -nat |awk '{print $6}'|sort|uniq -c|sort -rn

分析access.log获得访问前10位的ip地址
awk '{print $1}' access.log |sort|uniq -c|sort -nr|head -10






linux执行定时任务

crontab -e #编辑某个用户的cron服务
crontab -l #列出某个用户cron服务的详细内容
crontab -r #删除每个用户的cron服务

定时任务crontab格式(注意顺序)
分   小时    日     月   星期  命令
*     *      *      *     *   
0-59 0-23   1-31   1-12  0-6   command

注: "*" 代表取值范围内的数字
    "/" 代表每、比如每分钟

例如：
*/1 **** php /data/www/cron.php
#意思是每分钟执行cron.php

50 7 *** /sbin/service sshd start
#意思是每天7：50开启ssh服务



SSH服务

$ ssh host
$ ssh user@host
$ ssh -p 2222 user@host


公钥登录
所谓"公钥登录"，原理很简单，就是用户将自己的公钥储存在远程主机上。
登录的时候，远程主机会向用户发送一段随机字符串，用户用自己的私钥加密后，再发回来。
远程主机用事先储存的公钥进行解密，如果成功，就证明用户是可信的，直接允许登录shell，不再要求密码。

这种方法要求用户必须提供自己的公钥。如果没有现成的，可以直接用ssh-keygen生成一个：

Ssh-keygen是为SSH创建新的身份验证密钥对的工具
生成公钥/私有RSA密钥对(一对)
$ ssh-keygen
	
运行结束以后，在 ~/.ssh/目录下，会新生成两个文件：id_rsa.pub和id_rsa。
前者是你的公钥，后者是你的私钥。

--这时再输入下面的命令，将公钥传送到远程主机host上面：
$ ssh-copy-id user@host

--重启服务
/etc/init.d/ssh restart





##yum安装jenkins

--安装java环境

yum install java-1.8.0-openjdk  java-1.8.0-openjdk-devel  #安装openjdk

--yum安装jenkins

sudo wget -O /etc/yum.repos.d/jenkins.repo https://pkg.jenkins.io/redhat-stable/jenkins.repo
sudo rpm --import https://pkg.jenkins.io/redhat-stable/jenkins.io.key

yum install jenkins

--直接后台运行jenkins 
java -jar jenkins.war --httpPort=8080 >runtime.log & | &

配置jenkins
vim /etc/sysconfig/jenkins



##问题集

#!不能外网访问问题?
主机访问centos6.8虚拟机

[解决方法]
网络连接: 桥接模式

#设置防火墙
nano /etc/sysconfig/iptables
添加下行(复制22端口的做法)
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT

写入后记得把防火墙重起一下,才能起作用．
[root@tp ~]# service iptables restart

或:

-- 图形界面下 --
1、在终端中敲入命令 setup，
进入Firewall configuration 
2、tab键选择Customize  
3、上下箭头选择最后一项www（http）
这个是web服务器开通的80端口，
勾选上表示trusted 可信 。
这里就可以关闭 保存了
保存关闭后，window就可以访问了。 





centos7.x

--日志系统journal

删除旧有日志

如果大家打算对journal记录进行清理，则可使用两种不同方式（适用于systemd 218及更高版本）。

如果使用–vacuum-size选项，则可硬性指定日志的总体体积，意味着其会不断删除旧有记录直到所占容量符合要求：

sudo journalctl --vacuum-size=1G

另一种方式则是使用–vacuum-time选项。任何早于这一时间点的条目都将被删除。

例如，去年之后的条目才能保留：

sudo journalctl --vacuum-time=1years






--firewall 命令：


查看已经开放的端口：
firewall-cmd --list-ports

--要启动服务并在启动时启用FirewallD：
sudo systemctl start firewalld
sudo systemctl enable firewalld

--停止并禁用它：
sudo systemctl stop firewalld
sudo systemctl disable firewalld

--检查防火墙状态。输出应该说running或者not running。
sudo firewall-cmd --state

--要查看FirewallD守护进程的状态，请执行以下操作：
sudo systemctl status firewalld

--重新加载FirewallD配置：
sudo firewall-cmd --reload

显示一个服务的状态：systemctl status firewalld.service
启动一个服务：systemctl start firewalld.service
关闭一个服务：systemctl stop firewalld.service
重启一个服务：systemctl restart firewalld.service

在开机时启用一个服务：systemctl enable firewalld.service
在开机时禁用一个服务：systemctl disable firewalld.service
查看服务是否开机启动：systemctl is-enabled firewalld.service
查看已启动的服务列表：systemctl list-unit-files|grep enabled

--保存默认区域和常用服务等默认配置。避免更新它们，因为这些文件将被每个firewalld软件包更新覆盖。
/usr/lib/FirewallD

-- 保存系统配置文件。这些文件将覆盖默认配置
/etc/firewalld/


##################
添加端口
##################

1. 命令的方式添加端口

firewall-cmd --permanent --add-port=9527/tcp
1、firewall-cmd：是Linux提供的操作firewall的一个工具；
2、--permanent：表示设置为持久；
3、--add-port：标识添加的端口；

firewall中有Zone的概念，可以将具体的端口制定到具体的zone配置文件中。
例如:
firewall-cmd --zone=public --permanent --add-port=8010/tcp  
--zone=public：指定的zone为public；

firewall-cmd --zone=public --add-port=80/tcp --permanent
命令含义：

–zone #作用域

–add-port=80/tcp #添加端口，格式为：端口/通讯协议

–permanent #永久生效，没有此参数重启后失效


2.修改配置文件的方式添加端口

<?xml version="1.0" encoding="utf-8"?>
<zone>
  <short>Public</short>
  <description>For use in public areas.</description>
  <rule family="ipv4">
    <source address="122.10.70.234"/>
    <port protocol="udp" port="514"/>
    <accept/>
  </rule>
  <rule family="ipv4">
    <source address="123.60.255.14"/>
    <port protocol="tcp" port="10050-10051"/>
    <accept/>
  </rule>
 <rule family="ipv4">
    <source address="192.249.87.114"/> 放通指定ip，指定端口、协议
    <port protocol="tcp" port="80"/>
    <accept/>
  </rule>
<rule family="ipv4"> 放通任意ip访问服务器的9527端口
    <port protocol="tcp" port="9527"/>
    <accept/>
  </rule>
</zone>

重启防火墙

firewall-cmd --reload #重启firewall
systemctl stop firewalld.service #停止firewall
systemctl disable firewalld.service #禁止firewall开机启动
firewall-cmd --state #查看默认防火墙状态（关闭后显示notrunning，开启后显示running）

