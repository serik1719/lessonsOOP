<?php

class UserController{
    
    const PERIOD_RESTORE = 60;	//	Восстанавливать пароль можно через каждые 5 минут
    
    public function actionRegister(){
        if(!User::isGuest()){header('Location: /cabinet');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $login = '';
        $email = '';
        $password = '';
        $repassword = '';
        $captcha = '';
        $result = false;
        
        if(isset($_SESSION['result'])){
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        }
        
        if(isset($_POST['submit'])){
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $captcha = $_POST['captcha'];
            
            $errors = false;
            
            if(!User::checkCaptcha($captcha)){
                $errors[] = 'Проверочный код введён неверно';
            }else{
                if(!User::checkLogin($login)){$errors[] = 'Логин не должен быть короче 2-х символов';}
                if(!User::checkEmail($email)){$errors[] = 'Неверный email';}
                if(!User::checkPassword($password)){$errors[] = 'Пароль не должен быть короче 6-х символов';}
                if(!User::checkRepassword($repassword, $password)){$errors[] = 'Пароли должны совпадать';}
                if(User::checkLoginExists($login)){$errors[] = 'Такой Логин уже используется';}
                if(User::checkEmailExists($email)){$errors[] = 'Такой Е-mail уже используется';}
            }
            if($errors == false){
                if(!User::register($login, $email, $password)){
                    $errors[] = 'Сообщение на почту со ссылкой для активации аккаунта отправить не удалось! Пожалуйста, напишите администрации сайта!';
                }else{
                    $_SESSION['result'] = $email;
                    header('Location: /register');
                }
            }
        }
        
        $title = 'Регистрация';
        require_once ROOT. '/view/user/register.php';
        
        return true;
    }
    
    public function actionActive($code){
        if(!User::isGuest()){header('Location: /cabinet');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $result = User::activeUser($code);
        
        $title = 'Активация аккаунта';
        require_once ROOT.'/view/user/active.php';
        
        return true;
    }
    
    public function actionLogin(){
        if(!User::isGuest()){header('Location: /cabinet');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $login = '';
        $password = '';
        $captcha = '';
        
        if(isset($_POST['submit'])){
            $login = $_POST['login'];
            $password = $_POST['password'];
            $captcha = $_POST['captcha'];
            
            $errors = false;
            
            if(!User::checkCaptcha($captcha)){
                $errors[] = 'Проверочный код введён неверно';
            }else{
                if(!User::checkLogin($login)){$errors[] = 'Логин не должен быть короче 2-х символов';}
                if(!User::checkPassword($password)){$errors[] = 'Пароль не должен быть короче 6-х символов';}
                if(User::checkLogin($login) && User::checkPassword($password)){
                    if(!User::checkLoginExists($login)){
                        $errors[] = 'Пользователь с таким логином не зарегистрирован';
                    }else{
                        if(!$id = User::getIdUserByLoginPassword($login, $password)){
                            $errors[] = 'Неверный пароль';
                        }else{
                            if(User::checkUserActivityById($id) == -1){$errors[] = 'Аккаунт заблокирован';}
                            if(User::checkUserActivityById($id) == 0){$errors[] = 'Аккаунт неактивен';}
                        }
                    }
                }
            }
            if($errors == false){
                User::authorize($id);
                header("Location: /cabinet");
            }
        }
        
        $title = 'Авторизация';
        require_once  ROOT. '/view/user/login.php';
        
        return true;
    }
    
    public function actionRestore(){
        if(!User::isGuest()){header('Location: /cabinet');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        $email = '';
        $captcha = '';
        $result = false;
        
        if(isset($_SESSION['result'])){
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        }
        
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $captcha = $_POST['captcha'];
            
            $errors = false;
            
            if(!User::checkCaptcha($captcha)){
                $errors[] = 'Проверочный код введён неверно';
            }else{
                if(!$id = User::checkEmailExists($email)){
                    $errors[] = 'Пользователь с таким e-mail не зарегистрирован';
                }else{
                    if(User::checkUserActivityById($id) == -1){
                        $errors[] = 'Аккаунт заблокирован';
                    }else{
                        $restore = 0;
                        if(isset($_SESSION['restore'])){$restore = $_SESSION['restore'];}
                        if((time()-$restore) <= self::PERIOD_RESTORE){$errors[] = 'Следующий запрос можно отправить через '.(self::PERIOD_RESTORE - (time()-$restore)).' секунд!';}
                    }
                }
            }
            if($errors == false){
                if(!User::restore($email)){
                    $errors[] = 'Сообщение на почту со ссылкой для восстановления пароля отправить не удалось! Пожалуйста, напишите администрации сайта!';
                }else{
                    $_SESSION['result'] = $email;
                    header('Location: /restore');
                }
            }
        }
        
        $title = 'Восстановление пароля';
        require_once ROOT.'/view/user/restore.php';
        
        return true;
    }
    
    public function actionCode($code){
        if(!User::isGuest()){header('Location: /cabinet');}
        
        $categoriesList1 = Category::getCategoriesList(1);
        $categoriesList2 = Category::getCategoriesList(2);
        
        if(isset($_SESSION['result'])){
            $result = $_SESSION['result'];
            unset($_SESSION['result']);
        }
        
        if($id = User::checkRestoreCodeExists($code)){
            $password = '';
            $repassword = '';
            $result = false;
            
            if(isset($_POST['submit'])){
                $password = $_POST['password'];
                $repassword = $_POST['repassword'];
                
                $errors = false;
                
                if(!User::checkPassword($password)){$errors[] = 'Пароль не должен быть короче 6-х символов';}
                if(!User::checkRepassword($repassword, $password)){$errors[] = 'Пароли должны совпадать';}
                
                if($errors == false){
                    $_SESSION['result'] = User::setPassword($id, $password);
                    header('Location: /code/'.$code);
                }
            }
        }
        
        $title = 'Ввод нового пароля';
        require_once ROOT.'/view/user/code.php';
        
        return true;
    }
    
    public static function actionLogout(){
        unset($_SESSION['user']);
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}