<?php
 class SystemA
 {
     public function run()
     {
         echo __CLASS__;
     }
 }

 class SystemB
 {
     public function run()
     {
         echo __CLASS__;
     }
 }

 class Facade
 {
     public $AModel;
     public $BModel;

     public function __construct()
     {
         $this->AModel = new SystemA();
         $this->BModel = new SystemB();
     }

     public function run()
     {
         $this->AModel->run();
         $this->BModel->run();
     }
 }

 $model = new Facade();
 $model->run();