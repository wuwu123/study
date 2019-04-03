## https的配置

~~~nginx
listen       443;
server_name  file.hdphp.cc;

 #设置长连接
keepalive_timeout   70;

#HSTS策略
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;

ssl                  on;
ssl_certificate /usr/local/openresty/nginx/conf/ssl/2005795_file.hdphp.cc.pem;
ssl_certificate_key /usr/local/openresty/nginx/conf/ssl/2005795_file.hdphp.cc.key;

#设置共享缓存空间 ，减少握手次数
ssl_session_cache   shared:SSL:10m;
ssl_session_timeout  5m;

ssl_protocols  SSLv2 SSLv3 TLSv1;

# 定义算法
ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;

#优先采取服务器算法
ssl_prefer_server_ciphers   on;

 #减少点击劫持
add_header X-Frame-Options DENY;
#禁止服务器自动解析资源类型
add_header X-Content-Type-Options nosniff;
#防XSS攻擊
add_header X-Xss-Protection 1;
~~~

[学习地址](<https://aotu.io/notes/2016/08/16/nginx-https/index.html>)

