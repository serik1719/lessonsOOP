<?php

class CabinetController{
    
    public function actionIndex(){
        if(User::isGuest()){header('Location: /login');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $title = 'Кабинет';
        require_once ROOT. '/view/cabinet/index.php';
        
        return true;
    }
    
    public function actionEdit(){
        if(User::isGuest()){header('Location: /login');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $password = '';
        $repassword = '';
        $phone = $_SESSION['user']['phone'];
        $result = false;
        
        if(isset($_SESSION['result'])){
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        }
        
        if(isset($_POST['submit'])){
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];

            $errors = false;
            
            if(!User::checkPhone($phone) && !empty($phone)){$errors[] = 'Неверный номер телефона';}
            if(!empty($password) || !empty($repassword)){
                if(!User::checkPassword($password)){$errors[] = 'Пароль не должен быть короче 6-х символов';}
                if(!User::checkRepassword($repassword, $password)){$errors[] = 'Пароли должны совпадать';}
            }
            
            if($errors == false){
                if(!empty($password) || !empty($repassword)){
                    $_SESSION['result'] = User::setPassword($_SESSION['user']['id'], $password);
                }
                $_SESSION['result'] = User::setPhone($_SESSION['user']['id'], $phone);
                header('Location: /cabinet/edit');
            }
        }
        
        $title = 'Редактирование данных';
        require_once ROOT. '/view/cabinet/edit.php';
        
        return true;
    }
    
    public function actionOrders(){
        if(User::isGuest()){header('Location: /login');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        echo $title = 'Список заказов';
        echo ' пока в разработке';
        //require_once ROOT. '/view/cabinet/index.php';
        
        return true;
    }
}