<?php

class Db{
    
    public static function getConnection(){
        $parametrsPath = ROOT.'/config/db_parametrs.php';
        $parametrs = include $parametrsPath;
        
        $dsn = "mysql:host={$parametrs['host']}; dbname={$parametrs['dbname']}";
        
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'');
        
        $db = new PDO($dsn, $parametrs['user'], $parametrs['password'], $options);
        
        return $db;
    }
}