<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 28.08.2018
 * Time: 07:18
 */

class Router
{

    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include ($routesPath);
    }

    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
//            return substr($_SERVER['REQUEST_URI'], strlen('/shopAndOther/'));
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {

        $uri = $this->getURI();
//        echo $uri;
//        echo '<pre>';
//        print_r($this->routes);
//        echo '</pre>';
//        echo 'eee';

        $i=0;
        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~$uriPattern~", $uri)) {
                $i++;

//                echo '<br>Где ищем (запрос, который набрал пользователь): '.$uri;
//                echo '<br>Что ищем (совпадение из правила): '.$uriPattern;
//                echo '<br>Кто обрабатывает: '.$path;
//                echo "<br>";


                $internalRoute = preg_replace("~$uriPattern~", $path, $uri); //Выполняет поиск совпадений в строке $uri с шаблоном $uriPattern и заменяет их на $path.

//                echo '<br><br>Нужно сформировать: '.$internalRoute;

                $segments = explode('/', $internalRoute);
//                echo '<pre>';
//                print_r($segments);
//                echo '</pre>';

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
//                echo $controllerName;

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;


                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                if (file_exists($controllerFile)) {
                    include_once ($controllerFile);
                }

                $controllerObject = new $controllerName;
//                $result = $controllerObject->$actionName($parameters);

//                echo $actionName;
//                echo "<br>";
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }

            }
        }
    }
}