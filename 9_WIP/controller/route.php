<?php 
require $_SERVER["CONTEXT_DOCUMENT_ROOT"].'/autoload.php';

class Route_C{
private static array $routes = [];
private static ?bool $pathNotFound;
private static ?bool $methodNotAllowed;

public static function add( string $expression,callable $function, string $method = 'get'): void{
  array_push(self::$routes,Array(
    'expression' => $expression,
    'function' => $function,
    'method' => $method
  ));
}
public static function pathNotFound(callable $function): void{
  self::$pathNotFound = $function;
}

public static function methodNotAllowed(callable $function): void{
  self::$methodNotAllowed = $function;
}

public static function run(string $basepath = '/'): void{

  // Parse current url    ["path"]=> string(6) "/ocr2/"
  $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

  if(isset($parsed_url['path'])){
    $path = $parsed_url['path'];
  }else{
    $path = '/';
  }

  // Get current request method  "GET"
  $method = $_SERVER['REQUEST_METHOD'];
  
  $path_match_found = false;

  $route_match_found = false;
// ["expression"]=> string(1) "/" ["function"]=> object(Closure)#2 (0) { } ["method"]=> string(3) "get"

  foreach(self::$routes as $route){

    // If the method matches check the path

    // Add basepath to matching string
    // /ocr2
    if($basepath!=''&&$basepath!='/'){
      $route['expression'] = '('.$basepath.')'.$route['expression'];
    }

    // Add 'find string start' automatically
    // $route['expression'] = $route['expression'];

    // Add 'find string end' automatically
    $route['expression'] = '@'.'^'.$route['expression'].'$'.'@i';
    $route['expression'] = str_replace('/','\/',$route['expression']);
    // echo $route['expression'].'<br/>';
    // var_dump(preg_match($route['expression'],$path,$matches));
    // var_dump($matches);
    // Check path match	 ["path"]=> string(6) "/ocr2/admin"
    // if(preg_match('#'.$route['expression'].'#',$path,$matches)){
    if(preg_match($route['expression'],$path,$matches)){

      $path_match_found = true;

      // Check method match
      if(strtolower($method) == strtolower($route['method'])){

        array_shift($matches);// Always remove first element. This contains the whole string
        // var_dump($matches);
        if($basepath!=''&&$basepath!='/'){
          array_shift($matches);// Remove basepath
        }

        call_user_func_array($route['function'], $matches);

        $route_match_found = true;

        // Do not check other routes
        break;
      }
    }
  }

  // No matching route was found
  if(!$route_match_found){

    // But a matching path exists
    if($path_match_found){
      header("HTTP/1.0 405 Method Not Allowed");
      if(self::$methodNotAllowed){
        call_user_func_array(self::$methodNotAllowed, Array($path,$method));
      }
    }else{
      header("HTTP/1.0 404 Not Found");
      if(self::$pathNotFound){
        call_user_func_array(self::$pathNotFound, Array($path));
      }
    }

  }

}

}
?>