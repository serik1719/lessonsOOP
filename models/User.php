<?php

class User{
    
    /**
     * Кодирует строку
     * 
     * Возвращает запароленную строку
     */
    private static function myCoding($password){
        return md5('serik'.$password.'1719');
    }
    
    /**
     * Проверка авторизован ли пользователь. TRUE если гость
     * @return boolean
     */
    public static function isGuest(){
        if(isset($_SESSION['user'])){
            return false;
        }
        return true;
    }
    
    public static function checkUserActivityById($id){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'SELECT active '
                . 'FROM users '
                . 'WHERE id = :id '
                );
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->fetch(PDO::FETCH_ASSOC)){
            return $result['active'];
        }
        return false;
    }
    
    public static function authorize($userId){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'SELECT * '
                . 'FROM users '
                . 'WHERE id = :id '
                );
        $result->bindParam(':id', $userId, PDO::PARAM_STR);
        $result->execute();
        
        $result = $result->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['user']['id'] = $userId;
        $_SESSION['user']['login'] = $result['login'];
        $_SESSION['user']['email'] = $result['email'];
        $_SESSION['user']['password'] = $result['password'];
        $_SESSION['user']['date_reg'] = $result['date_reg'];
        $_SESSION['user']['phone'] = $result['phone'];
        $_SESSION['user']['typeuser'] = $result['typeuser'];
    }
    
    public static function register($login, $email, $password){
        $db = Db::getConnection();
        
        $password = self::myCoding($password);
        $code = md5($email.rand(0,999));
        
        $result = $db->prepare(
                'INSERT INTO users (login, email, password, date_reg, restore) '
                . 'VALUES (:login, :email, :password, now(), :code) '
                );
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':code', $code, PDO::PARAM_STR);
        $result->execute();
        
        include_once './config/maininfo.php';
        
        $subject = "Регистрация на сайте \"{$NameSiteRus}\"";
        $message = "С помощью вашего email была произведена регистрация "
                . " на сайте \"{$NameSiteRus}\".\r\n"
                . "Для активации аккаунта перейдите "
                . "по ссылке {$DomenFull}/active/".$code;
        
        if(EmailMessage($email, $subject, $message, $NameSiteRus, $EmailSite)){
            return true;
        }
        return false;
    }
    
    public static function restore($email){
        $db = Db::getConnection();
        
        $code = md5($email.rand(0,999));
        
        $result = $db->prepare(
                'UPDATE users '
                . 'SET restore = :code '
                . 'WHERE email = :email '
                );
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':code', $code, PDO::PARAM_STR);
        $result->execute();
        
        $_SESSION['restore'] = time();
        
        include_once './config/maininfo.php';
        
        $subject = "Восстановление пароля \"{$NameSiteRus}\"";
        $message = "С помощью вашего email была произведена попытка "
                . "востановления пароля на сайте \"{$NameSiteRus}\".\r\n"
                . "Если это были вы, тогда перейдите "
                . "по ссылке {$DomenFull}/code/".$code;
        
        if(EmailMessage($email, $subject, $message, $NameSiteRus, $EmailSite)){
            return true;
        }
        return false;
    }
    
    public static function activeUser($code){
        $db = Db::getConnection();
        
        $restore = '';
        
        $result = $db->prepare(
                'UPDATE users '
                . 'SET active = 1 , restore = :restore '
                . 'WHERE restore = :code '
                );
        $result->bindParam(':code', $code, PDO::PARAM_STR);
        $result->bindParam(':restore', $restore, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->rowCount()){
            return true;
        }
        return false;
    }
    
    public static function setPassword($id, $password){
        $db = Db::getConnection();
        
        $password = self::myCoding($password);
        $restore = '';
        
        $result = $db->prepare(
                'UPDATE users '
                . 'SET password = :password , restore = :restore '
                . 'WHERE id = :id '
                );
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':restore', $restore, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->rowCount()){
            if (isset($_SESSION['user'])) {
               $_SESSION['user']['password'] = $password; 
            }
            return true;
        }
        return false;
    }
    public static function setPhone($id, $phone){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'UPDATE users '
                . 'SET phone = :phone '
                . 'WHERE id = :id '
                );
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->rowCount()){
            $_SESSION['user']['phone'] = $phone;
            return true;
        }
        return false;
    }
    
    public static function checkCaptcha($captcha){
        if(md5($captcha) == $_SESSION['captcha']){
            return true;
        }
        return false;
    }
    
    public static function checkLogin($login){
        if(mb_strlen($login, 'utf-8') >= 2){
            return true;
        }
        return false;
    }
    
    public static function checkEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
    
    public static function checkPassword($password){
        if(mb_strlen($password, 'utf-8') >= 6){
            return true;
        }
        return false;
    }
    
    public static function checkRepassword($repassword, $password){
        if($repassword == $password){
            return true;
        }
        return false;
    }
    
    public static function checkLoginExists($login){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'SELECT count(*) '
                . 'FROM users '
                . 'WHERE login = :login '
                );
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();
        
        if($result->fetchColumn()){
            return true;
        }
        return false;
    }
    
    public static function checkEmailExists($email){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'SELECT id '
                . 'FROM users '
                . 'WHERE email = :email '
                );
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->fetch(PDO::FETCH_ASSOC)){
            return $result['id'];
        }
        return false;
    }
    
    public static function checkRestoreCodeExists($code){
        $db = Db::getConnection();
        
        $result = $db->prepare(
                'SELECT id '
                . 'FROM users '
                . 'WHERE restore = :code '
                );
        $result->bindParam(':code', $code, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->fetch(PDO::FETCH_ASSOC)){
            return $result['id'];
        }
        return false;
    }
    
    public static function getIdUserByLoginPassword($login, $password){
        $db = Db::getConnection();
        
        $password = self::myCoding($password);
        
        $result = $db->prepare(
                'SELECT * '
                . 'FROM users '
                . 'WHERE login = :login and password = :password '
                );
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();
        
        if($result = $result->fetch(PDO::FETCH_ASSOC)){
            return $result['id'];
        }
        return false;
    }
    
    public static function checkPhone($phone){
        if(preg_match('/[^0-9+-]/', $phone)) return false;              //  должны быть символы только "0123456789-+"
        if(strlen($phone)>21 || strlen($phone)<11) return false;        //  номер должен быть 11-21 символ
        if(preg_match('/-/', substr($phone, 0, 1))) return false;       //  первый символ не должен быть "-"
        if(preg_match('/[-+]/', substr($phone, -1, 1))) return false;   //  последний символ должна быть цифра
        if(preg_match('/[+]/', substr($phone, 1))) return false;        //  "+" может быть только первым символом
        if(preg_match('/--/', substr($phone, 1))) return false;         //  подрят не должно быть больше одного символа "--"
        if(preg_match('/0/', substr($phone, 0, 1))) return false;       //  телефон не должен начинаться с "0"
        if(preg_match('/\+0/', substr($phone, 0, 2))) return false;     //  телефон не должен начинаться с "+0"
        
        return true;
    }
    
    public static function checkAdmin(){
        if(!isset($_SESSION['user']['typeuser']) || $_SESSION['user']['typeuser'] != 2){
            Router::ErrorPage404();
        }
    }
}
