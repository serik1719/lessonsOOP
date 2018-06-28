<?php

class CatalogController
{
    const SHOW_BY_DEFAULT = 8;
    
    public function actionIndex($page = 1)
    {
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $total = Product::getTotalProduct();
        $pagination = new Pagination('/catalog/page-', $page, $total, self::SHOW_BY_DEFAULT);
        
        $latesProducts = Product::getLatesProductsForPage($page, self::SHOW_BY_DEFAULT);
        
        $title = "Все товары";
        require_once ROOT.'/view/product/index.php';
        
        return true;
    }

    public function actionCategory($categoryId, $page = 1)
    {
        $categoryId = intval($categoryId);
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        if(!$categoryName = Category::getNameCategory($categoryId)){
            Router::ErrorPage404();
        }
        
        $total = Product::getTotalProductInCategory($categoryId);
        $pagination = new Pagination('/category/'.$categoryId.'/page-', $page, $total, Product::SHOW_BY_DEFAULT);
        
        $latesProducts = Product::getProductListByCategoryForPage($categoryId, $page, self::SHOW_BY_DEFAULT);
        
        $title = $categoryName;
        require_once ROOT.'/view/product/index.php';
        
        return true;
    }
}