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
            pcntl_sigprocmask(SIG_BLOCK, array(SIGINT, SIGQUIT, SIGTERM), $oldset);  //进入循环时 屏蔽信号;感觉正常情况下是不需要的
            $i++;
            echo $i . PHP_EOL;
            sleep(1);
            echo $i . PHP_EOL;
            sleep(1);
            echo $i . PHP_EOL;
            sleep(1);
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