<?php

/* Las líneas `use App\Config\ResponseHttp;` y `use App\Controllers\UserController;` están importando
la clase `ResponseHttp` del espacio de nombres `App\Config` y la clase `UserController` del espacio de nombres `App\Controllers` . */

use App\Config\ResponseHttp;
use App\Controllers\UserController;


/* La variable `método` almacena el método HTTP utilizado en la solicitud. Se obtiene de la variable
superglobal `["REQUEST_METHOD"]` y se convierte a minúsculas usando la función `strtolower()`. */

$method = strtolower($_SERVER["REQUEST_METHOD"]);
var_dump($method);


/* `htmlspecialchars( ['route']."/");` está desinfectando y codificando el valor del
parámetro `['route'], que esta en la variable 'route' que se crea dinamicaente en el htacces ubicado en la raiz del ptoyecto.
`htmlspecialchars` es una función PHP que convierte caracteres especiales en sus correspondientes
entidades HTML. Se utiliza para evitar ataques de secuencias de comandos entre sitios (XSS)
codificando caracteres que tienen un significado especial en HTML, como `<`, `>`, `"`, `'` y `&`.
Mediante el uso de `htmlspecialchars `, cualquier entrada del usuario que se muestre en un contexto
HTML se codifica correctamente, lo que garantiza que se represente como texto y no se interprete
como código HTML.*/
$route = $_GET['route'];
$route = htmlspecialchars($_GET['route']);
var_dump($route);


/* La variable `params` se utiliza para almacenar los parámetros extraídos de la ruta. En este código,
la ruta se divide en segmentos usando la función `explode()`, y cada segmento se almacena como un
elemento en la matriz `params`. Estos parámetros se pueden utilizar para determinar qué controlador
y método deben manejar la solicitud. */
$paramsRoutes = explode('/', $route);
var_dump($paramsRoutes);



/* La variable `data` se utiliza para almacenar los datos JSON que se envían en el cuerpo de la
solicitud. Se obtiene decodificando el contenido del cuerpo de la solicitud usando `json_decode(file_get_contents('php://input'), true)`. 
`file_get_contents('php://input')` es una función PHP que lee los datos sin procesar del cuerpo de la solicitud. En este código, se utiliza para recuperar los datos JSON enviados en el cuerpo de la solicitud. La secuencia `php://input`
le permite leer los datos de entrada sin procesar como una cadena, que luego puede procesarse o decodificarse según sea necesario. */
$data = json_decode(file_get_contents('php://input'), true);

var_dump($data);


/* La variable `headers` se utiliza para almacenar todos los encabezados HTTP que se envían en la
solicitud. Se obtiene usando la función `getallheaders()`. Estos encabezados pueden incluir
información como el tipo de contenido, las credenciales de autenticación y cualquier encabezado
personalizado que se incluya en la solicitud. */
$header = getallheaders();

var_dump($method);
var_dump($route);
var_dump($paramsRoutes);
var_dump($data);
var_dump($header);


/* Se está creando una instancia del `UserController` con los parámetros `method,  $route,  $params, $data, $header`. Esto significa que se está creando una nueva instancia de la clase `UserController` y los valores de estos parámetros se pasan a su constructor.
La variable `app`. Se utiliza para manejar la solicitud entrante llamando al controlador y método apropiados según el método HTTP, la ruta y otros parámetros. La clase `UseControllers` es responsable de procesar la solicitud y generar la respuesta adecuada.*/
$app = new UserController($method,  $route,  $paramsRoutes, $data, $header);

$app->getLogin("user/");
/* La declaración `if` verifica si el método HTTP es `POST` y la ruta es `user/`. Si ambas
condiciones son verdaderas, llama al método `post()` de la instancia `UserController` ($app) con el
parámetro `'user/'`. Este método es responsable de manejar la solicitud POST para la ruta
`user/`. */

if ($method == 'post' && $route == 'user/') {
	var_dump($method);
	var_dump($route);

	$app->postVerificarDatos('user/');
} else {
	var_dump($method);
	var_dump($route);
	echo json_encode(ResponseHttp::status404(CE_404 . ": user.php ==> Ruta incorrecta "));
}
