<?php

class CartController{
    
    public function actionIndex(){
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $productsInCart = Cart::getProducts();
        
        $products = array();
        
        if($productsInCart){
            //  получаем полную информацию о товарах списка
            $productsIds = array_keys($productsInCart);
            sort($productsIds);
            
            $products = array();
            foreach ($productsIds as $productsId){
                if(is_array(Product::getProductById($productsId))){
                    $products[] = Product::getProductById($productsId);
                }else{
                    $products[] = $productsId;
                }
            }
            
            //  получаем общую стоимость товаров
            $totalPrice = Cart::getTotalPriceInCart();
        }
        
        $title = "Корзина";
        require_once ROOT.'/view/cart/index.php';
        
        return true;
    }
    
    public function actionClear(){
        Cart::clear();
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    public function actionAdd($id){
        echo Cart::addProduct($id);
        return true;
    }
    
    public function actionMinus($id){
        Cart::minusProduct($id);
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    
    public function actionDelete($id){
        Cart::deleteProduct($id);
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    
    public function actionOrder() {
        if(User::isGuest()){header('Location: /login');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $totalPrice = Cart::getTotalPriceInCart();
        if($totalPrice == 0 && !isset($_SESSION['result'])){
            header('Location: /cart');
        }
        
        $firstname = '';
        $lastname = '';
        $middlename = '';
        $phone = $_SESSION['user']['phone'];
        $email = $_SESSION['user']['email'];
        $comment = '';
        $result = false;
        
        if(isset($_SESSION['result'])){
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        }
        
        if(isset($_POST['submit'])){
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $middlename = $_POST['middlename'];
            $phone = $_POST['phone'];
            $comment = $_POST['comment'];

            $errors = false;
            
            if(empty($firstname)){$errors[] = 'Фамилия не указано';}
            if(empty($lastname)){$errors[] = 'Имя не указана';}
            if(empty($middlename)){$errors[] = 'Отчество не указано';}
            if(empty($phone)){
                $errors[] = 'Телефон не указан';
            }else{
                if(!User::checkPhone($phone) && !empty($phone)){$errors[] = 'Неверный номер телефона';}
            }
            if(mb_strlen($comment, 'utf-8') > 200){$errors[] = 'Комментарий должен быть до 200 символов';}
                
            if($errors == false){
                
                $fio = $firstname.' '.$lastname.' '.$middlename;
                $_SESSION['result'] = Order::save($_SESSION['user']['id'], $fio, $phone, $email, $comment);
                
                $totalPrice = number_format(Cart::getTotalPriceInCart(), 2, ',', ' ');
                $link = $_SERVER['HTTP_ORIGIN'].'/admin/orders';
                
                include_once './config/maininfo.php';
                $subject = "Новый заказ \"{$NameSiteRus}\"";
                $message = "Пользователь оформил заказ на сайте \"{$NameSiteRus}\"\r\n"
                        . "ФИО: {$fio}\r\n"
                        . "Телефон: {$phone}\r\n"
                        . "E-mail: {$email}\r\n"
                        . "Комментарий: {$comment}\r\n"
                        . "Общая сумма заказа {$totalPrice} BYN"
                        . "\r\nПерейти к заказам {$link}";
                EmailMessage($email, $subject, $message, $NameSiteRus, $EmailSite);
                
                Cart::clear();
                
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
        
        
        
        
        $title = "Оформление заказа";
        require_once ROOT.'/view/cart/order.php';
        
        return true;
    }
}