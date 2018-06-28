<?php

class ProductController
{
    public function actionView($id)
    {
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $id = intval($id);
        $product = Product::getProductById($id);
        if(!$product){
            Router::ErrorPage404();
        }
        
        $categoryName = Category::getNameCategory($product['category_id']);
        
        //  получение списка продуктов этой же категории для отображения справа
        $countProducts = 4;
        $totalProductInCategory = Product::getTotalProductInCategory($product['category_id']);
        $lastPage = ceil($totalProductInCategory / $countProducts);
        $page = rand(1, $lastPage);
        $listProducts = Product::getProductListByCategoryForPage($product['category_id'], $page, $countProducts);
        
        //  получение списка изображений товара
        $images = Product::getListImagesProduct($id);
        
        //  создаём заранее, а то с JS работает калично
        Image::createMiniImages($images, 'single_mini', 300, 300);
        Image::createMiniImages($images, 'single', 700, 700);
        
        $title = $product['name'];
        require_once ROOT.'/view/product/single.php';
        
        return true;
    }
}
