## PHP信号管理

~~~php
<?php
class Asys
{
    public $asys = true;
    public function __construct()
    {
        pcntl_async_signals(true); //开启异步信号处理
        pcntl_signal(SIGINT, function(){
            $this->asys = false;
            echo '捕获到SIGINT信号' . PHP_EOL;
        });
    }
   

    public function do()
    {
        echo "begin".PHP_EOL;
        $i = 0;
        while($this->asys)
        {   
            pcntl_sigprocmask(SIG_BLOCK, array(SIGINT, SIGQUIT, SIGTERM), $oldset);  //进入循环时 屏蔽信号
            $i++;
            echo $i . PHP_EOL;
            sleep(1);
            echo $i . PHP_EOL;
            sleep(1);
             pcntl_sigprocmask(SIG_UNBLOCK, array(SIGINT, SIGQUIT, SIGTERM), $oldset); //代码块执行完解除信号屏蔽
        }
        echo "end".PHP_EOL;
    }

}

$classModel = new Asys();
$classModel->do();
~~~









## php扩展

### 显示扩展信息

```
查看PHP 扩展信息 
	php -m
查看 php 扩展详细信息
	php --ri redis
```



## [PSR](https://psr.phphub.org/)

| 序号 | 标题                                                         | 撰稿者                  | 协调者         | 发起人         |
| ---- | ------------------------------------------------------------ | ----------------------- | -------------- | -------------- |
| 1    | [基础编码规范](https://phphub.org/topics/2078)          | Paul M. Jones           | *N/A*          | *N/A*          |
| 2    | [编码风格规范](https://phphub.org/topics/2079)               | Paul M. Jones           | *N/A*          | *N/A*          |
| 3    | [日志接口规范](https://phphub.org/topics/2080)               | Jordi Boggiano          | *N/A*          | *N/A*          |
| 4    | [自动加载规范](https://phphub.org/topics/2081)               | Paul M. Jones           | Phil Sturgeon  | Larry Garfield |
| 6    | [缓存接口规范](https://phphub.org/topics/2082)               | Larry Garfield          | Paul Dragoonis | Robert Hafner  |
| 7    | [HTTP 消息接口规范](https://github.com/summerblue/psr.phphub.org/blob/master/psrs/%E3%80%8CPSR%20%E8%A7%84%E8%8C%83%E3%80%8DPSR-7%20HTTP%20%E6%B6%88%E6%81%AF%E6%8E%A5%E5%8F%A3%E8%A7%84%E8%8C%83.md) | Matthew Weier O'Phinney | Beau Simensen  | Paul M. Jones  |

## 测试一下
是是是
