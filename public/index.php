<?php
// // if (isset($_GET['route'])) {
// //    //  print "Existe variable de etorno  route ==> index.php" . "<br><br>";
// // } else {
// //    //  print("No existe variable de etorno  route ==> index.php" . "<br><br>");
// // }



/* La declaración `use` se utiliza para importar espacios de nombres en PHP. En este caso, se trata de importar las clases `ErrorLog` y `ResponseHttp` del espacio de nombres `\App\Config`. */

use \App\Config\ErrorLog;
use App\Config\ResponseHttp;


/* El código `requiere dirname(__DIR__) . "./vendor/autoload.php"; requiere nombre de
directorio(__DIR__) . "/public/codigosEstado.php";` incluye dos archivos en el script PHP. */

require dirname(__DIR__) . "/vendor/autoload.php";
require dirname(__DIR__) . "/public/codigosEstado.php";

ErrorLog::activateErroLog();

// //// var_dump($_GET['route']);
// //// var_dump(dirname(__DIR__) . "/vendor/autoload.php");
// //// var_dump(dirname(__DIR__)  . "/public/codigosEstado.php");
/* Cargando rutas de forma dinamica:
 La condición `if (isset(['route'])) {` es verificar si el parámetro `route` está configurado en
la cadena de consulta de URL. Si está configurado significa que se ha solicitado una ruta
específica. */
if (isset($_GET['route'])) {
   $url = explode('/', $_GET['route']);
   // //// var_dump($url);
   /* La línea ` = ['auth', 'user']` está creando una matriz llamada `$routesAuth` con dos elementos:
   'auth' y 'user'. Esta matriz se uti liza para comprobar si la ruta solicitada está autorizada. Si
   la ruta solicitada no está en la matriz `$routesAuth`, significa que la ruta no está autorizada y se
   devuelve una respuesta 400 Bad Request. */
   $routesAuth = ['auth', 'user']; // Sitios autorizados
   // //// var_dump($routesAuth);


   /* La línea `  = dirname(__DIR__) . '/src/Rutas/' . [0] . '.php';` está creando una ruta de archivo basada en el valor del primer elemento en la matriz `$url[]`. */
   $rutaArchivo = dirname(__DIR__) . '/src/Routes/' . $url[0] . '.php';
   // //// var_dump($rutaArchivo);

   /* El código `if (!in_array([0], ))` está verificando si el valor de `$url[0]` (el  primer elemento en la matriz`) no está presente en ` Matriz  $routesAuth. */
   if (!in_array($url[0], $routesAuth)) {
      echo json_encode(ResponseHttp::status400(CE_400 . ": index.php Ruta no autorizada "));
      exit;
   }

   /* La función `is_readable()` comprueba si el archivo especificado por la variable `file` es legible. Si el archivo es legible, significa que el script PHP puede acceder y leer el contenido del archivo. Si el archivo no es legible, puede indicar un problema de permiso del archivo o que el archivo no existe. */
   if (is_readable($rutaArchivo)) {
      // //// var_dump($rutaArchivo);

      /* La línea `require ;` es la que incluye y ejecuta el código PHP del archivo especificado por la variable `$rutaArchivo`. Esto permite que el script cargue y ejecute el código en el archivo de ruta especificado, que puede contener lógica, funciones o clases adicionales necesarias para la
ruta solicitada. */
      require $rutaArchivo;
      exit();
   } else {
      echo json_encode(ResponseHttp::status500(CE_500 . ": Index.php ERROR: No se puede leer arcivo ==> index.php"));
   }
} else {

   echo json_encode(ResponseHttp::status500(CE_500 . ": index.php  ERROR: No existe Variable Global ==> index.php"));
}
