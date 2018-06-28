<?php

class News
{
    const SHOW_BY_DEFAULT = 4;
    
    public static function getNewsItemById($id)
    {
        $db = Db::getConnection();
        
        $id = intval($id);
        
        $result = $db->query(
                ' SELECT * '
                . 'FROM records '
                . 'WHERE id='.$id
                );

        $newsItem = $result->fetch(PDO::FETCH_ASSOC);

        if(!$newsItem){
            Router::ErrorPage404();
        }

        return $newsItem;   
    }
    
    public static function getNewsListForPage($page)
    {
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        
        $db = Db::getConnection();
        
        $result = $db->query(
                ' SELECT id, name, date, text '
                . 'FROM records '
                . 'ORDER BY date DESC '
                . 'LIMIT ' . self::SHOW_BY_DEFAULT . ' '
                . 'OFFSET ' . $offset
                );
        
        $newsList = array();
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $newsList[] = $row;
        }
        
        if(!$newsList){
            return FALSE;
        }
        
        return $newsList;
    }
    
    public static function getTotalNews(){
        $db = Db::getConnection();
        
        $result = $db->query(
                ' SELECT count(id) AS count '
                . 'FROM records '
                );
        
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $row = $result->fetch();
        
        return $row['count'];
    }
}