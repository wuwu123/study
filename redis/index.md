## 配置

```
设置密码
    requirepass wujie
ip限制
    bind 127.0.0.1 ::1
    bind 127.0.0.1
```

## 清空数据

```

flushall

flushdb
```

## 库相关的命令

```
dbsize 查看当前库得keys 总数
```

## 使用基础情况

### 一般 Redis 服务器信息，包含以下域：

```
redis_version : Redis 服务器版本
redis_git_sha1 : Git SHA1
redis_git_dirty : Git dirty flag
os : Redis 服务器的宿主操作系统
arch_bits : 架构（32 或 64 位）
multiplexing_api : Redis 所使用的事件处理机制
gcc_version : 编译 Redis 时所使用的 GCC 版本
process_id : 服务器进程的 PID
run_id : Redis 服务器的随机标识符（用于 Sentinel 和集群）
tcp_port : TCP/IP 监听端口
uptime_in_seconds : 自 Redis 服务器启动以来，经过的秒数
uptime_in_days : 自 Redis 服务器启动以来，经过的天数
lru_clock : 以分钟为单位进行自增的时钟，用于 LRU 管理
```

### clients : 已连接客户端信息

```
connected_clients : 已连接客户端的数量（不包括通过从属服务器连接的客户端）
client_longest_output_list : 当前连接的客户端当中，最长的输出列表
client_longest_input_buf : 当前连接的客户端当中，最大输入缓存
blocked_clients : 正在等待阻塞命令（BLPOP、BRPOP、BRPOPLPUSH）的客户端的数量
```

### [memory : 内存信息](https://www.zybuluo.com/zero1036/note/160012)

```
used_memory : 由 Redis 分配器分配的内存总量，以字节（byte）为单位
used_memory_human : 以人类可读的格式返回 Redis 分配的内存总量
used_memory_rss : 从操作系统的角度，返回 Redis 已分配的内存总量（俗称常驻集大小）。这个值和top 、 ps 等命令的输出一致。
used_memory_peak : Redis 的内存消耗峰值（以字节为单位）
used_memory_peak_human : 以人类可读的格式返回 Redis 的内存消耗峰值
used_memory_lua : Lua 引擎所使用的内存大小（以字节为单位）
mem_fragmentation_ratio :used_memory_rss 和 used_memory 之间的比率
mem_allocator : 在编译时指定的， Redis 所使用的内存分配器。可以是 libc 、 jemalloc 或者 tcmalloc 。

在理想情况下， used_memory_rss 的值应该只比used_memory 稍微高一点儿。
当 rss > used ，且两者的值相差较大时，表示存在（内部或外部的）内存碎片。
内存碎片的比率可以通过 mem_fragmentation_ratio 的值看出。
当 used > rss 时，表示 Redis 的部分内存被操作系统换出到交换空间了，在这种情况下，操作可能会产生明显的延迟。
Because Redis does not have control over how its allocations are mapped to memory pages, highused_memory_rss is often the result of a spike in memory usage.

当 Redis 释放内存时，分配器可能会，也可能不会，将内存返还给操作系统。
如果 Redis 释放了内存，却没有将内存返还给操作系统，那么 used_memory 的值可能和操作系统显示的 Redis 内存占用并不一致。
查看 used_memory_peak 的值可以验证这种情况是否发生。

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
