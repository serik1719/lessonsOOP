<?php

class Router
{
    private $routes;
    
    public function __construct(){
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include $routesPath;
    }
    
    /**
     * Return request string
     */
    public function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])){
            if(trim($_SERVER['REQUEST_URI'], '/') == ''){
                //  пускай сайт работает и по "сайт/" и по "сайт/index"
                return 'index';
            }
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){
        //  если предыдущая страница потребовала (Router::setRedirect())
        self::redirect();
        
        $uri = $this->getURI();
        $error404 = true;
        
        // Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path){
  //  echo $path."<br>";
            
            //  пропускаем ошибочные пустые ключи
            if(empty($uriPattern)) {
                continue;
            }
            
            if(preg_match("~$uriPattern~", $uri)){
                // Получаем внутренний путь из внешнего согласно правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
  //  echo $internalRoute = preg_replace("~$uriPattern~", $path, $uri)."<br>";
                
                // Определить какой controller и action обрабатывают запрос
                $segments = explode('/', $internalRoute);
                
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;
                
        /*        //  Просмотр название контроллера, экшена, параметров
            
                echo $controllerName."<br>".$actionName."<br>";
                if($parameters){
                    echo "<pre>";
                    print_r($parameters);
                    echo "</pre>";
                    echo "<br>";
                }
                return;
        */    
                
                // Подключаем файл класса-контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                if(file_exists($controllerFile)){
                    include_once $controllerFile;
                }else{
                    $controllerFile = ROOT.'/controllers/admin/'.$controllerName.'.php';
                    if(file_exists($controllerFile)){
                        include_once $controllerFile;
                    }else{
                        die('Подключите файл ' . $controllerName);
                    }
                }
                
                $controllerObject = new $controllerName;
                
                if(method_exists($controllerObject, $actionName)){
                    // вызываем действие контроллера (вызываем метод action)
                    // Аналогичная функции выше, только передаёт методу $actionName класса $controllerObject массив параметров $parametrs
                    $result = call_user_func_array(array($controllerObject,$actionName), $parameters);
                    $error404 = false;
                    break;
		}
		else{
                    Router::ErrorPage404();
		}
            }
        }
        if($error404){
            Router::ErrorPage404();
        }
    }
    
    /**
     * Неверная страница / страница не найдена
     */
    public static function ErrorPage404(){
        exit(header('Location: /404'));
    }
    
    /**
     * Перенаправляет на указанную страницу после отправки формы
     * запрещая повторную отправку формы
     */
    public static function redirect(){
        if(isset($_SESSION['redirect'])){
            $redirect = $_SESSION['redirect'];
            unset($_SESSION['redirect']);
            header('Location: '.$redirect);
        }
    }
    
    /**
     * Устанавливаем страницу редиректа.
     * Сам редирект произойдёт авторматически уже <b>ЗДЕСЬ</b>
     */
    public static function setUrlRedirectr($urlRedirect){
        $_SESSION['redirect'] = $urlRedirect;
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
}