<?php

class Category
{
    /**
     * Возвращает список категорий по разделу (секции)<br>
     * Тип возвращаемого значения <b>array</b> or <b>false</b>
     */
    public static function getCategoriesList($section){
        
        $db = Db::getConnection();
        
        $result = $db->query(
                ' SELECT id, name '
                . 'FROM categories '
                . 'WHERE section='.$section.' and status=1 '
                . 'ORDER BY sort_order ASC '
                );
        
        $categoriesList = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $categoriesList[] = $row;
        }
        
        return $categoriesList;
    }
    
    /**
     * Возвращает наименование категории по id категории<br>
     * Возвращает <b>string</b> или "<b>Нет категории</b>"
     */
    public static function getNameCategory($id) {
        
        $db = Db::getConnection();
        
        $result = $db->query(
                ' SELECT name '
                . 'FROM categories '
                . 'WHERE id='.$id
                );
        
        $category = $result->fetch(PDO::FETCH_ASSOC);
        
        if(!$category){
            return false;
        }
        
        return $category['name'];
    }
    
    public static function getCategoriesListAdmin(){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'SELECT * '
                . 'FROM categories '
                . 'ORDER BY sort_order ASC '
                );
        $result->execute();
        
        $categoriesList = array();
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $categoriesList[] = $row;
        }
        
        return $categoriesList;
    }
}