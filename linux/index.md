## 防火墙



### centos7防火墙

```
firewall-cmd --reload

添加端口
firewall-cmd --permanent --add-port=3306/tcp

查询端口是否开通
firewall-cmd --query-port=3306/tcp
```

