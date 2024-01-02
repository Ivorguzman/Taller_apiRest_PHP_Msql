<?php
/* 
{
"name":"hugo",
"dni":"114",
"email":"prueba@prueba.com",
"rol":"2",
"password":"123456788",
"confirPassword":"123456789"

*/


/* La línea `espacio de nombres App\Models;` declara el espacio de nombres para la clase `UserModel`.
Los espacios de nombres se utilizan para organizar clases, interfaces, funciones y constantes en
grupos lógicos y evitar conflictos de nombres. En este caso, la clase `UserModel` se coloca en el
espacio de nombres `App\Models`, por ser una clase de modelo relacionada con la lógica empresarial de la aplicación. */

namespace App\Models;

/* Las declaraciones `use` en PHP se utilizan para importar espacios de nombres. En este caso, el
código importa las clases `ResponseHttp`, `Security`, `ConnectionDB` y `Sql` desde sus respectivos
espacios de nombres (`App\Config` y `App\DB`). */

use App\Config\ResponseHttp;
use App\Config\Security;
use App\DB\ConnectionDB;
use App\DB\Sql;



/* La clase UserModel es una clase PHP que representa a un usuario en una base de datos y proporciona
métodos para obtener y configurar información del usuario, así como un método para registrar un
nuevo usuario. */

class UserModel extends ConnectionDB
{

	/* El fragmento de código declara variables estáticas privadas en la clase `UserModel`. Estas variables
se utilizan para almacenar los valores de diversas propiedades relacionadas con un usuario, como
nombre, DNI (número de identificación), correo electrónico, rol, contraseña, IDToken y fecha. */
	private static string $name;
	private static string $dni;
	private static string $email;
	private static int    $rol;
	private static string $password;

	private static string $IDToken;
	private static string $date;



	/* La función es un constructor que inicializa las propiedades de la clase con valores de una matriz. */
	public function __construct(array $data)
	{
		//  print("PRUEBA userModel.php => function	_constructor()" . "<br><br>");
		// var_dump($data['email']);

		self::$name   = $data['name'];
		self::$dni      = $data['dni'];
		self::$email   = $data['email'];
		self::$rol      = $data['rol'];
		self::$password = $data['password'];
	}


	/** INICIO GETERS Y SETERS
	 * Este código PHP define  clases con métodos getter y setter para varias propiedades como nombre,
	 * DNI, correo electrónico, rol, contraseña, token de identificación y fecha.
	 */
	final public static function getName(): string
	{
		return self::$name;
	}
	final public static function setName(string $name)
	{
		self::$name = $name;
	}
	final public static function getDni(): string
	{
		return self::$dni;
	}
	final public static function setDni(string $dni)
	{
		self::$dni = $dni;
	}
	final public static function getEmail(): string
	{
		return self::$email;
	}
	final public static function setEmail(string $email)
	{
		self::$email = $email;
	}
	final public static function getRol(): int
	{
		return self::$rol;
	}
	public static function setRol(int $rol)
	{
		self::$rol = $rol;
	}
	final public static function getPassword(): string
	{
		return self::$password;
	}
	final public static function setPassword(string $password)
	{
		self::$password = $password;
	}

	final public static function getIDToken(): string
	{
		return self::$IDToken;
	}
	final public static function setIDToken(string $IDToken)
	{
		self::$IDToken = $IDToken;
	}
	final public static function getDate(): string
	{
		return self::$date;
	}
	final public static function setDate(string $date)
	{
		self::$date = $date;
	}
	//  FIN GETERS Y SETERS





	/***************************************Login******************************************/
	/* La función `login()` es un método estático en la clase `UserModel`. Se utiliza para autenticar a un
usuario comparando su correo electrónico y contraseña con la base de datos. */
	final public static function login()
	{
		try {

			$conn = self::getConnection();

			/* La línea de código ` = "SELECT * FROM usuario WHERE correo = :correo ";` está asignando una
			consulta SQL a la variable `$sql`. Esta consulta selecciona todas las columnas (`*`) de la tabla`usuario` donde el valor de la columna `correo` es igual al valor del parámetro `:correo`. El`:correo` es un parámetro con nombre que será reemplazado con un valor real cuando se ejecute laconsulta. */
			$sql = "SELECT * FROM usuario WHERE correo = :correo ";

			$resulSetSqlPreparada = $conn->prepare($sql);
			// // //  print("Pruebas UserModel.php");
			// //// var_dump($resulSetSqlPreparada);

			/* Esta matriz se utiliza para vincular el valor de `self::getEmail()` al marcador
				de posición `:correo` en la declaración preparada. */
			// //// var_dump(self::getEmail());

			$asignar_valores_parametros = array(':correo' => self::getEmail());

			// //// var_dump($asignar_valores_parametros[':correo']);

			/* La línea ` ->execute();` está ejecutando una declaración  preparada con los valores
			asignados a los marcadores de posición en la consulta SQL. El array
			$asignar_valores_parametros` contiene los valores que estarán vinculados a los marcadores
			deposición en la declaración preparada. Luego se llama al método `execute()` 
			sobre el objeto de declaración preparado `  $resulSetSqlPreparada` 
			con el array `$asignar_valores_parametros` como argumento.Esto
			ejecutará la declaración preparada con los valores asignados,
			reemplazando los marcadores de posición en la consulta SQL con los valores reales. */
			$resulSetSqlPreparada->execute($asignar_valores_parametros);
			// // // //// var_dump($resulSetSqlPreparada->execute($asignar_valores_parametros));
			// //// var_dump($resulSetSqlPreparada->rowCount());

			if ($resulSetSqlPreparada->rowCount() === 0) {
				return ResponseHttp::status400(CE_400 . ': UserModel-< Usuario no existe en base de datos >-');
			} else {
				foreach ($resulSetSqlPreparada as $datosResultSet) {

					// // // var_dump($datosResultSet); // Contenido del Result Set
					// // // var_dump(self::getPassword());
					// // // var_dump($datosResultSet['password']);

					if (Security::validarMiPassword(self::getPassword(), $datosResultSet['password'])) {

						// // // var_dump($datosResultSet['password']);

						/* En el código, la variable `$IdentificadorToken` se utiliza para almacenar una matriz asociativa que 	contiene los datos que se codificarán en el JSON Web Token (JWT). Estos datos incluyen información sobre el usuario o la sesión. En este caso, la carga útil incluye el valor "IDToken" recuperado de la base de datos.*/
						$IdentificadorToken = ['IDToken' => $datosResultSet['IDToken']];

						// // // var_dump($IdentificadorToken);


						/* La variable `token` se utiliza para almacenar el (JWT) que se crea utilizando
						el método `Security::crearTokenJwt()`. Luego, este token se incluye en los datos de respuesta cuando un usuario inicia sesión correctamente. El JWT contiene información codificada sobre	el usuario o la sesión, como el IDToken del usuario. El token se puede utilizar con fines de autenticación y autorización en solicitudes posteriores al servidor. 

						 En el código proporcionado, la	variable `$IdentificadorToken` se usa para almacenar una matriz asociativa	que contiene los datos que se	codificarán en el JSON Web Token	(JWT). Estos datos incluyen	información sobre el usuario o la sesión. En este caso, la carga
						útil incluye el valor del	"IDToken" recuperado de la base de datos. */
						$token = Security::crearTokenJwt(Security::obtenerValorVariableEntorno(), $IdentificadorToken);

						// //// var_dump($token);

						/* La matriz `$data` se está creando para almacenar los valores del nombre, rol y token del usuario. Estos valores  contiene los datos obtenidos de la base de datos. Las claves `['nombre']` y `['rol']` . Esta matriz `$data` se devolverá como datos de respuesta cuando un usuario inicie sesión correctamente. */
						$dataLoginBaseDatos = [
							'name'  => $datosResultSet['nombre'],
							'rol'   => $datosResultSet['rol'],
							'token' => $token
						];

						// // // var_dump($dataLoginBaseDatos);

						return ResponseHttp::status200($dataLoginBaseDatos);
						// return ResponseHttp::status200($dataLoginBaseDatos . CE_200 . ' UserModel-< usuario y clave son correctos>-');
						// exit;
					} else {
						return ResponseHttp::status400(CE_400 . ': UserModel.php-< usuario o clave son incorrectos>-');
					}
				}
			}
		} catch (\PDOException $e) {
			error_log("UserModel::Login -> " . $e);
			die(json_encode(ResponseHttp::status500(CE_500 . ': UserModel.php-<No existe registro>-')));
		}
	}



	final public  static function	getTodosLosUsuarios()
	{
		try {
			/* El código siguiente prepara una declaración SQL para insertar datos en una tabla llamada 	"usuario". La declaración SQL incluye marcadores de posición para los valores que se insertarán, que se especifican mediante parámetros (con nombre). El código también establece el juego de
			caracteres en utf8 para la conexión de la base de datos. */
			$conn = self::getConnection();
			$conn->exec("SET CHARACTER SET utf8"); // Establciendo uso de caracteres especiales
			$sqlSinParametros = "SELECT * FROM usuario ";
			$pStm = $conn->prepare($sqlSinParametros);
			$pStm->execute();
			$resultSet = $pStm;

			// // // var_dump($pStm);

			$todosLosUsuarios['dataUsuarios'] = $resultSet->fetchAll(\PDO::FETCH_ASSOC);

			// // // var_dump($todosLosUsuarios);

			return $todosLosUsuarios;
		} catch (\PDOException $e) {
			error_log('UserModel.php => getTodosLosUsuarios()' . $e);
			exit(json_encode(ResponseHttp::status500(CE_500 . 'UserModel.php => Falla al obtener datos')));
		}
	}

	/* El código anterior es una función PHP llamada `getUsuarioEspesifico()` que recupera un usuario
	específico de una tabla de base de datos. */
	final public  static function	getUsuarioEspesifico()
	{
		//  print("PRUEBA userModel.php => function	getUsuarioEspesifico()" . "<br><br>");
		/* El código  siguiente ejecuta una consulta SQL para verificar si existe un usuario con una dirección 	de correo electrónico específica en la tabla "usuario". Primero establece una conexión con la base 	de datos y establece el juego de caracteres en utf8. Luego, prepara una declaración SQL con una consulta parametrizada para seleccionar el correo electrónico de la tabla "usuario" donde el correo electrónico coincide con el correo electrónico proporcionado. Asigna el valor del parámetro de 	correo electrónico mediante una matriz. Luego, la declaración preparada se ejecuta con los valores 	de los parámetros asignados. El conjunto de resultados se almacena en la variable . 	Luego, el código verifica el número de filas devueltas por la consulta. si el número de filas devueltas por el objeto `$resultSet` es igual a '0'. Si es así, devuelve una respuesta con un código de estado de 400 y un mensaje que dice "Usuario no registrado". */
		try {

			$conn = self::getConnection();
			$conn->exec("SET CHARACTER SET utf8"); // Establciendo uso de caracteres especiales
			$sqlConParametros = 'SELECT * FROM usuario WHERE correo = :correo';
			// // $sqlConParametros2 = "SELECT * FROM usuario WHERE correo='prueba1@prueba.com'";
			// var_dump(self::getEmail());

			$asignar_valores_parametros = array(
				':correo' => self::getEmail()
			);

			// var_dump($asignar_valores_parametros);

			$pStm = $conn->prepare($sqlConParametros);
			$pStm->execute($asignar_valores_parametros);
			// // $pStm->execute();
			$resultSet = $pStm;

			// var_dump($resultSet);
			// var_dump($resultSet->rowCount());


			if ($resultSet->rowCount() === 0) {
				return ResponseHttp::status400(': UserModel.php => function getUsuarioEspesifico() Usuario no registrado');
			}

			$todosLosUsuarios['dataUsuarios'] = $resultSet->fetchAll(\PDO::FETCH_ASSOC);

			return $todosLosUsuarios;
		} catch (\PDOException $e) {
			error_log('UserModel.php => getTodosLosUsuarios()' . $e);
			exit(json_encode(ResponseHttp::status500(CE_500 . 'UserModel.php => Falla al obtener datos')));
		}
	}



	/* El código anterior es una función PHP llamada "postCrearUsuario" que se utiliza para crear un nuevo usuario en una base de datos. */
	final public static function postCrearUsuario()
	{
		/* Este código if(..){..} comprueba si el DNI (número de identificación) y el correo electrónico proporcionados por el usuario ya existen en la base de datos. */
		if (Sql::existe("SELECT dni FROM usuario WHERE dni = :dni", ":dni", self::getDni())) {
			return ResponseHttp::status404(CE_404 . ' El DNI ya esta registrado');
		} else if (Sql::existe("SELECT correo FROM usuario WHERE correo = :correo", ":correo", self::getEmail())) {
			return ResponseHttp::status404(CE_404 . ' El Correo ya esta registrado');
		} else {
			/* El código está generando un token ID para el usuario concatenando su DNI (número de identificación) y correo electrónico. Luego aplica un hash a la cadena concatenada utilizando el	algoritmo SHA-512 y establece el valor hash como el token de identificación para el usuario.
			También establece la fecha y hora actuales como propiedad de fecha para el usuario. */
			$datosEncriptar = self::getDni() . self::getEmail();
			self::setIDToken(hash('sha512', $datosEncriptar));
			self::setDate(date("d-m-y H:i:s"));
		}
		try {
			/* El código siguiente prepara una declaración SQL para insertar datos en una tabla llamada 	"usuario". La declaración SQL incluye marcadores de posición para los valores que se insertarán, que se especifican mediante parámetros (con nombre). El código también establece el juego de
			caracteres en utf8 para la conexión de la base de datos. */
			$conn = self::getConnection();
			$conn->exec("SET CHARACTER SET utf8"); // Establciendo uso de caracteres especiales

			$sqlConParametros = "INSERT INTO usuario(nombre, dni, correo, rol, password, IDToken, fecha) VALUES (:nombre, :dni, :correo, :rol, :password, :IDToken, :fecha) ";

			$pStm = $conn->prepare($sqlConParametros);

			/* La matriz `$asignar_valores_parametros` se utiliza para almacenar los valores que se vincularán a
			los marcadores de posición de la declaración preparada en la consulta SQL. Cada par clave-valor
			de la matriz representa un marcador de posición y su valor correspondiente. */
			$asignar_valores_parametros = array(
				':nombre' => self::getName(),
				':dni' => self::getDni(),
				':correo' => self::getEMail(),
				':rol' => self::getRol(),
				':password' => Security::createMiPassword(self::getPassword()),
				':IDToken' => self::getIDToken(),
				':fecha' => self::getDate()
			);

			/* `->execute();` está ejecutando una declaración preparada con los
			valores asignados a los marcadores de posición en la consulta SQL. */
			$pStm->execute($asignar_valores_parametros);


			if ($pStm->rowCount() > 0) {
				return ResponseHttp::status200(CE_200 . 'Registro Exitoso');
			} else {

				return ResponseHttp::status500(CE_500 . 'Registro fallido');
			}
		} catch (\PDOException $PDOeth) {
			error_log('Usuario no se pudo regitrar ' . $PDOeth->getMessage() .
				'En la lina  '  . $PDOeth->getLine()) .
				$PDOeth->getFile();

			/* El bloque de código `// ===COMPROBACIONES===` y `// ===FIN COMPROBACIONES===` se utiliza con
			fines de depuración. Se trata de imprimir los valores de las variables
			`$asignar_valores_parametros` y `pStm` para comprobar sus valores durante la ejecución del
			código. Esto puede ayudar a identificar cualquier problema o error en el código al inspeccionar
			los valores de estas variables. */

			/* La línea `exit(json_encode(ResponseHttp::status500(CE_500 . ' Usuario no se pudo registrar')));`
			se utiliza para finalizar la ejecución del script y devolver una respuesta codificada en JSON con
			un código de estado de 500 (Interno Error del servidor) y un mensaje que indica que el registro
			del usuario falló. */
			exit(json_encode(ResponseHttp::status500(CE_500 . ' Usuario no se pudo regitrar')));
		}
	}
}
