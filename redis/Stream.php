<?php
class Stream
{
    /**
     * @var \Redis
     */
    public $redis;
    public  function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('120.27.110.172', 6379);
        $this->redis->auth('wujie');
        $this->redis->select(5);
    }
}
$redisClass = new Stream();
var_dump($redisClass->redis->incr("ffffff"));
?>
