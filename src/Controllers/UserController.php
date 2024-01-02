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
`__construct` que toma varios parámetros como `method`, `route`, `params`, ``dataUserController y `
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
		private $dataUserController, //Se obtiene decodificando el contenido del cuerpo de la solicitud 
		private $header
	) {
		print('PRUEBA UserControler.php = function __construct()');
		// // // var_dump($this->method);
		// // // var_dump($this->route);
		// // var_dump($this->paramsRoutes);
		var_dump($this->dataUserController);
		// // // var_dump($this->dataUserController['email']);
		// //// // // var_dump($this->dataUserController['password']);
		// // var_dump($this->dataUserController['confirPassword']);
		// //// // // var_dump($this->header);
	}
	/************************************Login***********************************************/
	/* La `función pública final getLogin(string )` es un método en la clase `UserController`. Se utiliza para manejar solicitudes GET a un punto final específico. */
	final public function getLogin(string $endPoint)
	{
		// // // var_dump($endPoint);


		if ($this->method == 'get' && $endPoint == $this->route) {
			// //// // // var_dump($this->paramsRoutes[1]);
			// //// // // var_dump($this->paramsRoutes[2]);
			$email = strtolower($this->paramsRoutes[1]);
			$password = $this->paramsRoutes[2];
			// //// // // var_dump($this->paramsRoutes[1]);
			// //// // // var_dump($this->paramsRoutes[2]);


			if (empty($email) || empty($password)) {
				echo json_encode(ResponseHttp::status400(CE_400 . ' Todos los campos son necesarios ==> UserController.php'));
			} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo json_encode(ResponseHttp::status400(CE_400 . ' Formato de correo invalido ==> UserController.php'));
			} else {
				// //// // // var_dump($email);
				// //// // // var_dump($password);
				UserModel::setEmail($email);
				UserModel::setPassword($password);
				/* `json_encode` es una función PHP que convierte un valor PHP (matriz, objeto, cadena, número, etc.) en una cadena JSON. */
				echo json_encode(UserModel::login());
			}
			exit;
		}
	}


	/**
	 * La función "getTodosLosUsuarios" en el código PHP recupera todos los usuarios si el método HTTP es  GET y el punto final coincide con la ruta.
	 * 
	 * @param string endPoint El parámetro  es una cadena que representa el punto final de la
	 * solicitud de API. Se utiliza para determinar si la solicitud actual coincide con el punto final
	 * especificado.
	 */
	final  public function getTodosLosUsuarios(string $endPoint)
	{

		if ($this->method == 'get' & $endPoint == $this->route) {
			//  print("PRUEBA UserController.php ==> function getTodosLosUsuarios()");
			// // // var_dump($this->method);
			// // // var_dump($endPoint);
			// // // var_dump($this->route);
			// // // // var_dump($this->paramsRoutes);

			//! AQUI !
			Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno());
			// // // // // var_dump(Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno()));

			echo json_encode(UserModel::getTodosLosUsuarios());

			exit;
		}
	}

	/**
	 * La función `getUsuarioEspesifico` P recupera un usuario específico en función de la  dirección de correo electrónico proporcionada.
	 * 
	 * @param string endPoint El parámetro  es una cadena que representa el punto final de la solicitud de API. Se utiliza para determinar si la solicitud actual coincide con el punto final  especificado.
	 */
	final  public function getUsuarioEspesifico(string $endPoint)
	{

		if ($this->method == 'get' & $endPoint == $this->route) {

			// //  print("PRUEBA UserController.php ==> function getUsuarioEspesifico");
			// // // var_dump($this->method);
			// // // var_dump($endPoint);
			// // // var_dump($this->route);
			// // var_dump($this->paramsRoutes);

			$emailUsuario = $this->paramsRoutes[1];

			// // // // var_dump($emailUsuario);
			// // // var_dump(isset($emailUsuario));
			// // // var_dump(!isset($emailUsuario));
			/* La declaración `if (!isset())` verifica si la variable `$emailUsuario` no está configurada o es nula. Si no está configurado o es nulo, significa que falta el parámetro del correo electrónico en la solicitud, por lo que devolverá una respuesta con un código de estado 400 y un mensaje de error indicando que el correo electrónico es requerido. */
			if (!isset($emailUsuario)) {
				// // // var_dump($emailUsuario);

				echo json_encode(ResponseHttp::status400('UserControlle.php function getUsuarioEspesifico => El email es requerido'));
			} else if (preg_match(self::$validate_number, $emailUsuario)) {
				echo json_encode(ResponseHttp::status400(CE_400 . ': UserModel.php => function getUsuarioEspesifico()'));
			} else {
				UserModel::setEmail($emailUsuario);
				echo json_encode(UserModel::getUsuarioEspesifico());
			}
			//! AQUI !
			Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno());
			// // // // // var_dump(Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno()));



			echo json_encode(UserModel::getUsuarioEspesifico());

			exit;
		}
	}



	/* La `función pública final solicitudPost(string )` es un método en la clase `UserController`. 
	*Se	utiliza para manejar solicitudes POST a un punto final específico. */
	final public  function postValidarDatos(string $endPoint)
	{
		/* La declaración `if` verifica si el método HTTP es POST y si el punto final coincide con la ruta.
		Si ambas condiciones son verdaderas, se ejecutará el código dentro del bloque "if". */

		if ($this->method == 'post' & $endPoint == $this->route) {
			//! AQUI !
			//  print("PRUEBA UserController.php ==> function postValidarDatos()");
			// // // var_dump($this->method);
			// // // var_dump($endPoint);
			// // // var_dump($this->route);
			// // // // // var_dump(Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno()));


			/* La línea `Security::validarTokenJwt(->header, Security::obtenerValorVariableEntorno());` está llamando a un método estático `validarTokenJwt()` de la clase `Security`. Este método se utiliza para validar un token web JSON (JWT) en función del encabezado proporcionado y los valores de las variables de entorno. Garantiza que el token sea válido y no haya caducado antes de permitir el acceso a determinadas rutas o recursos protegidos. */
			Security::validarTokenJwt($this->header, Security::obtenerValorVariableEntorno());



			/* La declaraciónes "if" realizan una serie de validaciones de los datos recibidos en la solicitud	POST. */
			if (
				empty($this->dataUserController['name']) || empty($this->dataUserController['dni']) || empty($this->dataUserController['email']) || empty($this->dataUserController['rol'])
				|| empty($this->dataUserController['password']) || empty($this->dataUserController['confirPassword'])
			) {
				echo json_encode(ResponseHttp::status400("Todos los campos son requeridos -< UserController.php>- "));
			} else  if (!preg_match(self::$validate_text, $this->dataUserController['name'])) {
				echo json_encode(ResponseHttp::status400("Campo texto. Solo se adimete texto -< UserController.php>- "));
			} else  if (!preg_match(self::$validate_number, $this->dataUserController['dni'])) {
				echo json_encode(ResponseHttp::status400("Campo dni. Solo admite numeros -< UserController.php>- "));
			} else  if (!filter_var($this->dataUserController['email'], FILTER_VALIDATE_EMAIL)) {
				echo json_encode(ResponseHttp::status400("Formato correo incorrecto -< UserController.php>- "));
			} else  if (!preg_match(self::$validate_rol, $this->dataUserController['rol'])) {
				echo json_encode(ResponseHttp::status400("Rol Invalido -< UserController.php>- "));
			} else if (strlen($this->dataUserController['password']) < 8 || strlen($this->dataUserController['confirPassword'] < 8)) {
				echo json_encode(ResponseHttp::status400("Password minimo 8 caracters -< UserController.php>- "));
			} else if ($this->dataUserController['password'] !== $this->dataUserController['confirPassword']) {
				echo json_encode(ResponseHttp::status400("Claves no coinsiden  -< UserController.php>-"));
			} else {
				/* El código `new UserModel(->dataUserController);` crea una nueva instancia de la clase `UserModel`,	pasando `->dataUserController` como parámetro al constructor. Esto permite que el objeto `UserModel`
				acceda y trabaje con los datos pasados en la solicitud. */
				new UserModel($this->dataUserController);
				echo json_encode(UserModel::postCrearUsuario()); // Pinta en el Html,en en formato Json las valores recividos
			}
			exit;
		}
	}

	/*****************Actualizar contraseña de usuario****************************/
	final public function patchPassword($endPoint)
	{
		if ($this->method == "patch" && $this->route == $endPoint) {

			$jwtDecodificado = Security::getDataJwt();
			if(empty($this->dataUserController))
		}
	}
}
