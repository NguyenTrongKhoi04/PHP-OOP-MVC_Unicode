<?php
abstract class BaseMiddleWare{
    public $db;
    
    abstract function handle();
}