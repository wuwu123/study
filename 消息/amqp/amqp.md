## 介绍
![系统架构](http://img.hdphp.cc/141c7d46dd7055c8a1be82a4746e8110.png)

### 几个核心概念

* Broker：经纪人。提供一种传输服务，维护一条从生产者到消费者的传输线路，保证消息数据能按照指定的方式传输。粗略的可以将图中的RabbitMQ Server当作Broker。

* Exchange：消息交换机。指定消息按照什么规则路由到哪个队列Queue。

* Queue：消息队列。消息的载体，每条消息都会被投送到一个或多个队列中。

* Binding：绑定。作用就是将Exchange和Queue按照某种路由规则绑定起来。

* RoutingKey：路由关键字。Exchange根据RoutingKey进行消息投递。

* Vhost：虚拟主机。一个Broker可以有多个虚拟主机，用作不同用户的权限分离。一个虚拟主机持有一组Exchange、Queue和Binding。

* Producer：消息生产者。主要将消息投递到对应的Exchange上面。一般是独立的程序。

* Consumer：消息消费者。消息的接收者，一般是独立的程序。

* Channel：消息通道，也称信道。在客户端的每个连接里可以建立多个Channel，每个Channel代表一个会话任务。

#### Exchange

Exchange类似于数据通信网络中的交换机，提供消息路由策略。rabbitmq中，producer不是通过信道直接将消息发送给queue，而是先发送给Exchange。
一个Exchange可以和多个Queue进行绑定，producer在传递消息的时候，会传递一个ROUTING_KEY，Exchange会根据这个ROUTING_KEY按照特定的路由算法，将消息路由给指定的queue。
和Queue一样，Exchange也可设置为持久化，临时或者自动删除。

##### Exchange有4种类型：direct(默认)，fanout, topic, 和headers，不同类型的Exchange转发消息的策略有所区别：

###### Direct

直接交换器，工作方式类似于单播，Exchange会将消息发送完全匹配ROUTING_KEY的Queue

![direct](http://img.hdphp.cc/794f7c39b8f4c320594b1384810ad8a4.png)

###### fanout

广播是式交换器，不管消息的ROUTING_KEY设置为什么，Exchange都会将消息转发给所有绑定的Queue。
![fanout](http://img.hdphp.cc/7e20c9c7c885306f32bcdb43a30719a7.png)

###### topic

主题交换器，工作方式类似于组播，Exchange会将消息转发和ROUTING_KEY匹配模式相同的所有队列，比如，ROUTING_KEY为user.stock的Message会转发给绑定匹配模式为 * .stock,user.stock， * . * 和#.user.stock.#的队列。（ * 表是匹配一个任意词组，#表示匹配0个或多个词组）

![topic](http://img.hdphp.cc/7f442d116cb491fbf43b17ecd61abfc6.png)

###### headers

同direct exchange类似，不同之处是不再使用Routing Key路由，而是使用headers（Message attributes）进行匹配路由到指定Queue。

### 消息流程

1. 客户端连接到消息队列服务器，打开一个channel。

2. 客户端声明一个exchange，并设置相关属性。

3. 客户端声明一个queue，并设置相关属性。

4. 客户端使用routing key，在exchange和queue之间建立好Binding关系。

5. 生产者客户端投递消息到exchange。

6. exchange接收到消息后，就根据消息的RoutingKey和已经设置的binding，进行消息路由（投递），将消息投递到一个或多个队列里。

7. 消费者客户端从对应的队列中获取并处理消息。

Consumer收到消息时需要显式的向rabbit broker发送basic.ack消息或者consumer订阅消息时设置auto_ack参数为true。在通信过程中，队列对ACK的处理有以下几种情况：

* 如果consumer接收了消息，发送ack,rabbitmq会删除队列中这个消息，发送另一条消息给consumer。
* 如果cosumer接受了消息, 但在发送ack之前断开连接，rabbitmq会认为这条消息没有被deliver,在consumer在次连接的时候，这条消息会被redeliver。
* 如果consumer接受了消息，但是程序中有bug,忘记了ack,rabbitmq不会重复发送消息。
* rabbitmq2.0.0和之后的版本支持consumer reject某条（类）消息，可以通过设置requeue参数中的reject为true达到目地，那么rabbitmq将会把消息发送给下一个注册的consumer。



### 学习参考地址
[简单明了](https://www.cnblogs.com/jun-ma/p/4840869.html)
[详细一点](https://blog.csdn.net/LeiXiaoTao_Java/article/details/78909760)
