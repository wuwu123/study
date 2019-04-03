<?php
class Singleton
{
    private static $instance;

    //面试点 实例只能自己创建
    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
}