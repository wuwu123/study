## 配置

```
设置密码
requirepass wujie
ip限制
bind 127.0.0.1 ::1
bind 127.0.0.1
```
## redis 大key

```
查询redis 每种类型的key的数量，各类型最大key的情况，和 key的平均大小
```

#### 执行参数

```
redis-cli -h <host> -p <port> -n <db> -a <PASSWORD> --bigkeys -i <ms>

ms 多少秒执行一次
```

### 执行结果集

```
Sampled 2057 keys in the keyspace!
Total key length in bytes is 45396 (avg len 22.07)

Biggest string found 'home:mini-course:list:2' has 3252 bytes
Biggest   list found 'meditation:queue:error' has 1 items
Biggest    set found 'mar:list:1' has 95 members
Biggest   hash found 'course:search:p:2' has 74 fields
Biggest   zset found 'ca:genre:9:2:list' has 29 members

820 strings with 11477 bytes (39.86% of keys, avg size 14.00)
1 lists with 1 items (00.05% of keys, avg size 1.00)
9 sets with 253 members (00.44% of keys, avg size 28.11)
1181 hashs with 5550 fields (57.41% of keys, avg size 4.70)
46 zsets with 199 members (02.24% of keys, avg size 4.33)
```
