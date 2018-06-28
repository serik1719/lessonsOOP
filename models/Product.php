<?php

class Product
{
    const SHOW_BY_DEFAULT = 4;
    
    public static function getStringStatusesProducts($status){
        $statusesString = '-1';
        if($status == 'active'){$statusesString .= ',1';}
        if($status == 'deactive'){$statusesString .= ',0';}
        if($status == 'all'){$statusesString .= ',0,1';}
        return $statusesString;
    }
    
    public static function getStringIsNewProducts($isNew) {
        $isNewString = '-1';
        if($isNew == 'new'){$isNewString .= ',1';}
        if($isNew == 'not_new'){$isNewString .= ',0';}
        if($isNew == 'all'){$isNewString .= ',0,1';}
        return $isNewString;
    }
    
    public static function getStringIsRecomendetProducts($isRecomendet) {
        $isRecomendetString = '-1';
        if($isRecomendet == 'recomendet'){$isRecomendetString .= ',1';}
        if($isRecomendet == 'not_recomendet'){$isRecomendetString .= ',0';}
        if($isRecomendet == 'all'){$isRecomendetString .= ',0,1';}
        return $isRecomendetString;
    }
    
    public static function getLatesProducts($count = self::SHOW_BY_DEFAULT, $status='active', $isNew='all', $isRecomendet='all')
    {
        $db = Db::getConnection();
        
        $statusesString = self::getStringStatusesProducts($status);
        $isNewString = self::getStringIsNewProducts($isNew);
        $isRecomendetString = self::getStringIsRecomendetProducts($isRecomendet);
        
        $result = $db->query(
                " SELECT * "
                . "FROM product "
                . "WHERE status IN ($statusesString) "
                . "AND is_new IN ($isNewString) "
                . "AND is_recomendet IN ($isRecomendetString) "
                . "ORDER BY id DESC "
                . "LIMIT " . $count . " "
                );
        
        $productsList = array();
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $productsList[] = $row;
        }
        
        return $productsList;
    }
    
    public static function getLatesProductsForPage($page, $count = self::SHOW_BY_DEFAULT, $status='active'){
        $db = Db::getConnection();
        
        $offset = ($page - 1) * $count;
        
        $statusesString = self::getStringStatusesProducts($status);
        
        $result = $db->query(
                " SELECT * "
                . "FROM product "
                . "WHERE status IN ($statusesString) "
                . "ORDER BY id DESC "
                . "LIMIT " . $count . " "
                . "OFFSET " . $offset
                );
        
        $productsList = array();
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $productsList[] = $row;
        }
        return $productsList;
    }
    
    public static function getProductListByCategoryForPage($categoryId, $page, $count = self::SHOW_BY_DEFAULT, $status='active'){
        
        $offset = ($page - 1) * $count;
        
        $db = Db::getConnection();
        
        $statusesString = self::getStringStatusesProducts($status);
        
        $result = $db->query(
                " SELECT * "
                . "FROM product "
                . "WHERE status IN ($statusesString) AND category_id=" . $categoryId . " "
                . "ORDER BY id DESC "
                . "LIMIT " . $count . " "
                . "OFFSET " . $offset
                );
        
        $productsList = array();
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $productsList[] = $row;
        }
        
        return $productsList;
    }
    
    public static function getProductById($id, $status='active'){
        $db = Db::getConnection();
        
        $statusesString = self::getStringStatusesProducts($status);
        
        $result = $db->query(
                " SELECT * "
                . "FROM product "
                . "WHERE status IN ($statusesString) AND id=" . $id . " "
                );
        
        $product = $result->fetch(PDO::FETCH_ASSOC);
        
        if(!$product){
            return false;
        }
        return $product;
    }
    
    public static function getProductsByIds($idsArray, $status='active'){
        $db = Db::getConnection();
        
        $idsString = implode(',', $idsArray);
        
        $statusesString = self::getStringStatusesProducts($status);
        
        $result = $db->query(
                " SELECT id, code, name, price "
                . "FROM product "
                . "WHERE status IN ($statusesString) AND id IN ($idsString) "
                );
        
        $products = array();
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            $products[] = $row;
        }
        
        if(!$products){
            return false;
        }
        
        return $products;
    }
    
    public static function getTotalProductInCategory($categoryId, $status='active'){
        $db = Db::getConnection();
        
        $statusesString = self::getStringStatusesProducts($status);
        
        $result = $db->query(
                " SELECT count(id) AS count "
                . "FROM product "
                . "WHERE status IN ($statusesString) AND category_id=" . $categoryId . ' '
                );
        
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $row = $result->fetch();
        
        return $row['count'];
    }
    
    public static function getTotalProduct($status='active'){
        $db = Db::getConnection();
        
        $statusesString = self::getStringStatusesProducts($status);
        
        $result = $db->query(
                " SELECT count(id) AS count "
                . "FROM product "
                . "WHERE status IN ($statusesString) "
                );
        
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        $row = $result->fetch();
        
        return $row['count'];
    }
    
    public static function deleteProductById($id){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                "DELETE FROM product "
                . "WHERE id = :id "
                );
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
    }
    
    public static function create($options){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                " INSERT INTO product "
                . "( name,  category_id,  code,  price,  availability,  brand,  description,  is_new,  is_recomendet,  status) "
                . "VALUES "
                . "(:name, :category_id, :code, :price, :availability, :brand, :description, :is_new, :is_recomendet, :status) "
                );
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_STR);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_STR);
        $result->bindParam(':is_recomendet', $options['is_recomendet'], PDO::PARAM_STR);
        $result->bindParam(':status', $options['status'], PDO::PARAM_STR);
        if($result->execute()){
            return $db->lastInsertId();
        }
        return false;
    }
    
    public static function update($options){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                "UPDATE product "
                . "SET name = :name, "
                . "category_id = :category_id, "
                . "code = :code, "
                . "price = :price, "
                . "availability = :availability, "
                . "brand = :brand, "
                . "description = :description, "
                . "is_new = :is_new, "
                . "is_recomendet = :is_recomendet, "
                . "status = :status "
                . "WHERE id = :id "
                );
        $result->bindParam(':id', $options['id'], PDO::PARAM_STR);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_STR);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_STR);
        $result->bindParam(':is_recomendet', $options['is_recomendet'], PDO::PARAM_STR);
        $result->bindParam(':status', $options['status'], PDO::PARAM_STR);
        return $result->execute();
    }
    
    /**
     * Получаем массив наименований изображений продкута
     */
    public static function getListImagesProduct($idProduct) {
        $db = Db::getConnection();
        
        $result = $db->prepare(
                "SELECT images "
                . "FROM product "
                . "WHERE id = :id "
                );
        $result->bindParam(':id', $idProduct, PDO::PARAM_STR);
        $result->execute();
        
        $result = $result->fetch(PDO::FETCH_ASSOC);
        
        if(empty($result['images'])){
            return false;
        }
        return json_decode($result['images']);
    }
    
    /**
     * Возвращаем последний номер изображения товара или 0
     */
    public static function getLastImageProduct($idProduct) {
        if($listImages = Product::getListImagesProduct($idProduct)){
            $lastImage = explode('_',end($listImages));
            return $lastImage[1];
        }else{
            return 0;
        }
    }
    
    /**
     * Возвращает главное изображение продукта
     */
    public static function getMainImage($idProduct){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                "SELECT main_image "
                . "FROM product "
                . "WHERE id = :id "
                );
        $result->bindParam(':id', $idProduct, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->fetch(PDO::FETCH_ASSOC)){
            return $result['main_image'];
        }
        return false;
    }
    
    /**
     * Устанавливает главное изображение продукта (пишет в ДБ)
     */
    public static function setMainImage($idProduct, $image = ''){
        $db = Db::getConnection();
        
        if(empty($image)){
            $images = Product::getListImagesProduct($idProduct);
            
            if(is_array($images)){
                $image = $images[0];
            }else{
                $image = '';
            }
        }
        
        $result = $db->prepare(
                "UPDATE product "
                . "SET main_image = :image "
                . "WHERE id = :id "
                );
        $result->bindParam(':id', $idProduct, PDO::PARAM_STR);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->execute();
    }
    
    /**
     * Дописываем изображение продкута в БД в виде Json
     */
    public static function addImageInListImagesProduct($idProduct, $nameImage) {
        $imagesArray = Product::getListImagesProduct($idProduct);
        $imagesArray[] = $nameImage;
        
        self::setListImagesProduct($idProduct, $imagesArray);
    }
    
    /**
     * Устанавливаем список изобжадений продкута в БД в Json виде
     */
    public static function setListImagesProduct($idProduct, $imagesArray) {
        $db = Db::getConnection();
        
        if(is_array($imagesArray)){
            $imagesJson = json_encode($imagesArray);
        }else{
            $imagesJson = '';
            echo 'пусто';
        }
        
        $result = $db->prepare(
                "UPDATE product "
                . "SET images = :images "
                . "WHERE id = :id "
                );
        $result->bindParam(':id', $idProduct, PDO::PARAM_STR);
        $result->bindParam(':images', $imagesJson, PDO::PARAM_STR);
        $result->execute();
    }
}
