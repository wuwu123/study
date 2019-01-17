## 重量级特性 Stream

redis 还没相应扩展

### 新特性

* stream是一个可持久化的消息队列， 对标kafka，解决了pubsub订阅发布功能不能持久化的问题；
* 支持分组多次消费，同样有group，消费者的概念。这样能通过多个group的形式
* 支持position，能够消费历史消息，也能轻松移动消费id位置，这样给故障恢复带来了很多可以操作的空间，不至于消息丢了，没办法重复获取历史消息；
* 有ACK机制，能够一定程度保证消息的“at least once” 投递。当然带来的问题也显而易见： consumer需要能够支持重放，消息可能重复到来。
* 消息可以设置最大保存范围，这样不用担心塞满内存。但是kafka不会立即持久化消息到磁盘，这个依赖aof等常规机制，这一点也很轻量。消息内容是保存在rdb文件里面的，而不是一堆文件。

### 流程图

![流程](http://img.hdphp.cc/36bbbc8f1e7bf0b7081400beea24ba74.png)

* 每个Stream都有唯一的名称，它就是Redis的key，在我们首次使用xadd指令追加消息时自动创建。

* 每个Stream都可以挂多个消费组，每个消费组会有个游标last_delivered_id在Stream数组之上往前移动，表示当前消费组已经消费到哪条消息了。每个消费组都有一个Stream内唯一的名称，消费组不会自动创建，它需要单独的指令xgroup create进行创建，需要指定从Stream的某个消息ID开始消费，这个ID用来初始化last_delivered_id变量。

* 每个消费组(Consumer Group)的状态都是独立的，相互不受影响。也就是说同一份Stream内部的消息会被每个消费组都消费到。

* 同一个消费组(Consumer Group)可以挂接多个消费者(Consumer)，这些消费者之间是竞争关系，任意一个消费者读取了消息都会使游标last_delivered_id往前移动。每个消费者者有一个组内唯一名称。

* 消费者(Consumer)内部会有个状态变量pending_ids，它记录了当前已经被客户端读取的消息，但是还没有ack。如果客户端没有ack，这个变量里面的消息ID会越来越多，一旦某个消息被ack，它就开始减少。这个pending_ids变量在Redis官方被称之为PEL，也就是Pending Entries List，这是一个很核心的数据结构，它用来确保客户端至少消费了消息一次，而不会在网络传输的中途丢失了没处理。

### 函数

1. xadd
2. xread 独立读取消息
2. xdel 将消息标记为已读
3. xrange 获取消息列表，过滤已读的
4. xlen
5. del
6. xgroup create 创建消费组

#### xadd

```
存储的类似于hash

xadd streamkey * key valyue

* 默认生成消息的key；样式 1527849629172-0 时间戳-产生的数据条数

```

### 参考学习地址

[源码分析](http://chenzhenianqing.com/articles/1622.html)
[使用实例](https://mp.weixin.qq.com/s?__biz=MzAwMDU1MTE1OQ==&mid=2653549949&idx=1&sn=7f6c4cf8642478574718ed0f8cf61409&chksm=813a64e5b64dedf357cef4e2894e33a75e3ae51575a4e3211c1da23008ef79173962e9a83c73&mpshare=1&scene=23&srcid=0717fZ8HWyv9FjbqVXO6cLsa#rd)
