<?php


/* Las líneas `use App\Config\ResponseHttp;` y `use App\Controllers\UserController;` están importando
la clase `ResponseHttp` del espacio de nombres `App\Config` y la clase `UserController` del espacio de nombres `App\Controllers` . */

use App\Config\ResponseHttp;
use App\Controllers\UserController;


/* La variable `método` almacena el método HTTP utilizado en la solicitud. Se obtiene de la variable superglobal `["REQUEST_METHOD"]` y se convierte a minúsculas usando la función `strtolower()`. */

$method = strtolower($_SERVER["REQUEST_METHOD"]);

// //var_dump($method);



/* La línea ` = ['ruta'];` está recuperando el valor del parámetro "ruta" de la cadena de consulta de la URL. Este parámetro se utiliza te para definir la ruta o el punto final que solicita el usuario.`_GET` es una variable superglobal en PHP que se utiliza para recuperar los valores de las variables enviadas al script actual a través de los parámetros de URL (cadena de consulta). Es una matriz asociativa donde las claves son los nombres de los parámetros de la URL y los valores son los valores correspondientes pasados en la URL. En el código proporcionado, `['route']` se usa para recuperar el valor del parámetro "ruta" de la cadena de consulta URL. */
$route = $_GET['route'];

// //var_dump($route);


/* La variable `params` se utiliza para almacenar los parámetros extraídos de la ruta. En este código,la ruta se divide en segmentos usando la función `explode()`, y cada segmento se almacena como un elemento en la matriz `params`. Estos parámetros se pueden utilizar para determinar qué controlador
y método deben manejar la solicitud. */
$paramsRoutes = explode('/', $route);

// //var_dump($paramsRoutes);



/* La variable `data` se utiliza para almacenar los datos JSON que se envían en el cuerpo de la solicitud. Se obtiene decodificando el contenido del cuerpo de la solicitud usando `json_decode(file_get_contents('php://input'), true)`. 

 La función `file_get_contents` se utiliza para leer el contenido de un archivo y devolverlo como una cadena. En el código proporcionado, `file_get_contents('php://input')` se utiliza para leer el cuerpo de la solicitud HTTP sin formato, que  contiene datos enviados por el cliente en una solicitud POST o PUT. Luego, la función `json_decode` se usa para decodificar los datos JSON en una matriz u objeto PHP. */
$data = json_decode(file_get_contents('php://input'), true);

// //var_dump($data);


/* La variable `headers` se utiliza para almacenar todos los encabezados HTTP que se envían en la solicitud. Se obtiene usando la función `getallheaders()`. Estos encabezados pueden incluir información como el tipo de contenido, las credenciales de autenticación y cualquier encabezado personalizado que se incluya en la solicitud. */
$headers = getallheaders();

// //var_dump($headers);

/* ******************************************************************************************************
 !La línea `->getLogin("auth/{[1]}/{[2]}");` está llamando al método`getLogin` de objeto `$App` (que es una instancia de la clase `UserController`). `{[1]}/{[2]}` está concatenando los valores de indice`[1]` y `[2]` de la matriz `$paramsRoutes`  con una barra diagonal ("/") en el medio. Esto se usa para construir una ruta dinámica para la llamada al método`getLogin` en la línea `->getLogin("auth/{[1]}/{[2]}");`. Los valores de`[1]` y `[2]` se insertan en la ruta como marcadores de posición, lo que permite el enrutamiento dinámico basado en los valores extraídos de la ruta de solicitud original. 
 ********************************************************************************************************* */

// //var_dump($paramsRoutes[1]);

// //var_dump($paramsRoutes[2]);

// //var_dump("auth/{$paramsRoutes[1]}/{$paramsRoutes[2]}");


/* Se está creando una instancia del `UserController` con los parámetros `method,  $route,  $params, $data, $headers`. Esto significa que se está creando una nueva instancia de la clase `UserController` y los valores de estos parámetros se pasan a su constructor.
La variable `app`. Se utiliza para manejar la solicitud entrante llamando al controlador y método apropiados según el método HTTP, la ruta y otros parámetros. La clase `UseControllers` es responsable de procesar la solicitud y generar la respuesta adecuada.*/
$app = new UserController($method,  $route,  $paramsRoutes, $data, $headers);


/* La línea `->getLogin("auth/{[1]}/{[2]}");` está llamando al método`getLogin` del objeto `` (que es una instancia de la clase `UserController`).
! EXPLICACION DEL METODO LINEAS MAS ARRIBA!
*/
// //var_dump("auth/{$paramsRoutes[1]}/{$paramsRoutes[2]}/");

$app->getLogin("auth/{$paramsRoutes[1]}/{$paramsRoutes[2]}/");
echo json_encode(ResponseHttp::status404(CE_404 . " auth.php ==> Ruta incorrecta"));
