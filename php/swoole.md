### centos 安装 swoole

```
yum install nghttp2
yum install hiredis
sudo ldconfig 刷新配置
pecl install swoole
添加配置
 php --ri swoole
```



### 安装 nghttp2

```
wget https://github.com/nghttp2/nghttp2/releases/download/v1.30.0/nghttp2-1.30.0.tar.bz2 

tar -jxvf nghttp2-1.30.0.tar.bz2

cd nghttp2-1.30.0

./configure

make

make install
```



### [hiredis安装](https://mengkang.net/822.html)

