## 防火墙



### centos7防火墙

```
yum install firewalld firewall-config
systemctl unmask firewalld.service
systemctl start  firewalld
firewall-cmd --reload

添加端口
firewall-cmd --permanent --add-port=3306/tcp

查询端口是否开通
firewall-cmd --query-port=3306/tcp
```





### 查看服务器版本

```
lsb_release -a
```
