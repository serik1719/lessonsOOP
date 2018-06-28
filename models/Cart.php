<?php

class Cart {

    public static function addProduct($id){
        
        //  Пустой массив для товаров в корзине
        $productsInCart = array();
        
        //  Если в корзине уже есть товары, то они сохраняются в сессию
        if(isset($_SESSION['products'])){
            //  То заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }
        
        //  Если товар есть в корзине, то добавляем количество
        //  иначе просто добавим его
        if(array_key_exists($id, $productsInCart)){
            $productsInCart[$id] ++;
        }else{
            $productsInCart[$id] = 1;
        }
        
        $_SESSION['products'] = $productsInCart;
        
        return self::countItems();
    }

    public static function minusProduct($id){
        
        $productsInCart = self::getProducts();
        
        if($productsInCart[$id] > 1){
            $productsInCart[$id] -= 1;
        }else{
            unset($productsInCart[$id]);
        }
        
        $_SESSION['products'] = $productsInCart;
    }

    public static function deleteProduct($id){
        
        $productsInCart = self::getProducts();
        
        unset($productsInCart[$id]);
        
        $_SESSION['products'] = $productsInCart;
    }
    
    public static function countItems(){
        if(isset($_SESSION['products'])){
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count += $quantity;
            }
            return $count;
        }else{
            return 0;
        }
    }
    
    public static function getProducts(){
        if(isset($_SESSION['products'])){
            return $_SESSION['products'];;
        }
        return false;
    }
    
    public static function getTotalPriceInCart(){
        $productsInCart = self::getProducts();
        
        $total = 0;
        
        $products = array();
        
        if($productsInCart){
            //  получаем полную информацию о товарах списка
            $productsIds = array_keys($productsInCart);
            
            $products = Product::getProductsByIds($productsIds);
            
            //  получаем общую стоимость товаров
            if(is_array($products)){
                foreach ($products as $item){
                    $total += $item['price'] * $productsInCart[$item['id']];
                }
            }
        }
        
        return $total;
    }
    
    public static function clear() {
        if(isset($_SESSION['products'])){
            unset($_SESSION['products']);
        }
    }
}