<?php

class SiteController
{
    public function actionTest($param){
        echo 'Тестируй наздоровье, только впиши /test/$1';
        
        return true;
    }
    
    public function actionIndex()
    {
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $latesProducts1 = Product::getLatesProducts(6, 'active', 'new', 'recomendet');
        $latesProducts2 = Product::getLatesProducts(8, 'active', 'new');
        $latesProducts3 = Product::getLatesProducts(3, 'active', 'all', 'recomendet');
        
        $title='Главная';
        require_once ROOT.'/view/site/index.php';
        
        return true;
    }
    
    public function actionPage404(){
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $title = "404";
        require_once ROOT.'/view/site/404.php';
        
        return true;
    }
    
    public function actionContacts(){
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $login = '';
        $email = '';
        $text = '';
        $captcha = '';
        $result = false;
        
        if(!User::isGuest()){
            $login = $_SESSION['user']['login'];
            $email = $_SESSION['user']['email'];
        }
        
        if(isset($_SESSION['result'])){
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        }
        
        if(isset($_POST['submit'])){
            $login = $_POST['login'];
            $email = $_POST['email'];
            $text = $_POST['text'];
            $captcha = $_POST['captcha'];
            
            $errors = false;
            
            if(!User::checkCaptcha($captcha)){
                $errors[] = 'Проверочный код введён неверно';
            }else{
                if(!User::checkLogin($login)){$errors[] = 'Логин не должен быть короче 2-х символов';}
                if(!User::checkEmail($email)){$errors[] = 'Неверный email';}
                if(strlen($text) < 100 || strlen($text) > 1000){$errors[] = 'Текст сообщения должен быть 100-1000 символов';}
            }
            if($errors == false){
                include_once './config/maininfo.php';
        
                $subject = "Сообщение админу \"{$NameSiteRus}\"";
                $text .= "\r\n\r\n от {$login} почта:{$email}";
                
                if(!EmailMessage($email, $subject, $text, $NameSiteRus, $EmailSite)){
                    $errors[] = 'Сообщение отправить неудалось, напишите администратору во ВКонтакте';
                }else{
                    $_SESSION['result'] = true;
                    header('Location: /contacts');
                }
            }
        }
        
        $title = "Мои контакты";
        require_once ROOT.'/view/site/contacts.php';
        
        return true;
    }
}