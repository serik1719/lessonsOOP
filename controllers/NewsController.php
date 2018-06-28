<?php

class NewsController
{
    public function actionIndex($page = 1)
    {
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $total = News::getTotalNews();
        $pagination = new Pagination('/news/page-', $page, $total, News::SHOW_BY_DEFAULT);
        
        $newsList = News::getNewsListForPage($page);
        
        $title='Новости';
        require_once ROOT.'/view/news/index.php';
        
        return true;
    }
    
    public function actionView($id)
    {
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $newsItem = News::getNewsItemById($id);
        
        $title = $newsItem['name'];
        require_once ROOT.'/view/news/single.php';
            
        return true;
    }
}
