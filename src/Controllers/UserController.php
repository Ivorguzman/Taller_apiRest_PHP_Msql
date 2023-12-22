<?php


/* La palabra clave `namespace` en PHP se utiliza para definir un espacio de nombres para una clase o
un grupo de clases relacionadas. Ayuda a organizar y agrupar clases, evitando conflictos de nombres
con clases de otros espacios de nombres. Los espacios de nombres proporcionan una forma de
encapsular clases y evitar colisiones de nombres en proyectos grandes o cuando se utilizan
bibliotecas de terceros. */

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\UserModel;

/* La `clase UseControllers` define una clase de controlador en PHP. Tiene un método constructor
`__construct` que toma varios parámetros como `method`, `route`, `params`, ``data y `
Estos parámetros se utilizan para inicializar las propiedades de la clase. */

class UserController
{
	/* Estas líneas de código definen patrones de expresiones regulares (regex) que se utilizan con fines
	de validación. */
	private static $validate_rol = '/^[1,2,3]{1,1}$/'; // El patrón a buscar, como una cadena.
	private static $validate_text = '/^[aA-zZ]+$/'; // El patrón a buscar, como una cadena.
	private static $validate_number = '/^[0-9]+$/'; // El patrón a buscar, como una cadena.
	/**
	 * La función es un constructor que inicializa las propiedades del método, la ruta, los parámetros,
	 * los datos y los encabezados.
	 */
	public function __construct( // Solo a partir de PHP 7

		private string $method,
		private string $route,
		private array $paramsRoutes,
		private $data, //Se obtiene decodificando el contenido del cuerpo de la solicitud 
		private $header
	) {
		var_dump($this->method);
		var_dump($this->route);
		var_dump($this->paramsRoutes);
		var_dump($this->data);
		var_dump($this->data['email']);
		var_dump($this->data['password']);
		var_dump($this->data['confirPassword']);
		var_dump($this->header);
	}
	/************************************Login***********************************************/
	/* La `función pública final getLogin(string )` es un método en la clase `UserController`. Se utiliza para manejar solicitudes GET a un punto final específico. */
	final public function getLogin(string $endPoint)
	{
		var_dump($endPoint);


		if ($this->method == 'get' && $endPoint == $this->route) {
			var_dump($this->paramsRoutes[1]);
			var_dump($this->paramsRoutes[2]);
			$email = strtolower($this->paramsRoutes[1]);
			$password = $this->paramsRoutes[2];
			var_dump($this->paramsRoutes[1]);
			var_dump($this->paramsRoutes[2]);

			if (empty($email) || empty($password)) {
				echo json_encode(ResponseHttp::status400(CE_400 . ' Todos los campos son necesarios ==> UserController.php'));
			} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo json_encode(ResponseHttp::status400(CE_400 . ' Formato de correo invalido ==> UserController.php'));
			} else {
				var_dump($email);
				var_dump($password);
				UserModel::setEmail($email);
				UserModel::setPassword($password);
				echo json_encode(UserModel::login());
			}
			exit;
		}
	}



	/* La `función pública final solicitudPost(string )` es un método en la clase `UserController`. 
	*Se	utiliza para manejar solicitudes POST a un punto final específico. */
	final public  function postVerificarDatos(string $endPoint)
	{
		/* La declaración `if` verifica si el método HTTP es POST y si el punto final coincide con la ruta.
		Si ambas condiciones son verdaderas, se ejecutará el código dentro del bloque "if". */
		if ($this->method == 'post' & $endPoint == $this->route) {

			//! Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno());

			/* La declaraciónes "if" realizan una serie de validaciones de los datos recibidos en la solicitud	POST. */
			if (
				empty($this->data['name']) || empty($this->data['dni']) || empty($this->data['email']) || empty($this->data['rol'])
				|| empty($this->data['password']) || empty($this->data['confirPassword'])
			) {
				echo json_encode(ResponseHttp::status400("Todos los campos son requeridos -< UserController>- "));
			} else  if (!preg_match(self::$validate_text, $this->data['name'])) {
				echo json_encode(ResponseHttp::status400("Campo texto. Solo se adimete texto -< UserController>- "));
			} else  if (!preg_match(self::$validate_number, $this->data['dni'])) {
				echo json_encode(ResponseHttp::status400("Campo dni. Solo admite numeros -< UserController>- "));
			} else  if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
				echo json_encode(ResponseHttp::status400("Formato correo incorrecto -< UserController>- "));
			} else  if (!preg_match(self::$validate_rol, $this->data['rol'])) {
				echo json_encode(ResponseHttp::status400("Rol Invalido -< UserController>- "));
			} else if (strlen($this->data['password']) < 8 || strlen($this->data['confirPassword'] < 8)) {
				echo json_encode(ResponseHttp::status400("Password minimo 8 caracters -< UserController>- "));
			} else if ($this->data['password'] !== $this->data['confirPassword']) {
				echo json_encode(ResponseHttp::status400("Claves no coinsiden  -< UserController>-"));
			} else {
				new UserModel($this->data);
				echo json_encode(UserModel::postCrearUsuario()); // Pinta en el Html,en en formato Json las valores recividos
			}
			exit;
		}
	}
}
