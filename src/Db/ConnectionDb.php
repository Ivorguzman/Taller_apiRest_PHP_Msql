<?php

namespace App\Db;

use App\Config\ResponseHttp;
use PDO;

require __DIR__ . "/dataDB.php";

class ConnectionDb
{
	private static $host = "";
	private static $user = "";
	private static $password = "";

	/* La función `from()` es una función estática que establece los valores de las propiedades `host`,`user` y `password` en la clase `ConnectionDb`. Le permite especificar el host, el nombre de
	usuario y la contraseña para la conexión de la base de datos. Estos valores se utilizarán másadelante al establecer la conexión a la base de datos. */
	final public static function from($host, $user, $password)
	{
		self::$host     = $host;
		self::$user     = $user;
		self::$password = $password;
	}

	/* El método `getConnection()'  función estática pública y final es un método estático que devuelve un
	objeto PDO que representa una conexión a una base de datos. Utiliza los valores de host, usuario y
	contraseña establecidos en el método `from()` para establecer la conexión. El método también
	establece el modo de recuperación predeterminado para el objeto PDO y establece el modo de error
	para generar excepciones. Si hay un error al establecer la conexión, registra el error y devuelve
	una respuesta JSON con un código de estado 500. */
	/* PDO::FETCH_ASSOC ( int )
	Especifica que el método de recuperación devolverá cada fila como una matriz indexada por el nombre de la columna tal como se devuelve en el conjunto de resultados correspondiente. Si el conjunto de resultados contiene varias columnas con el mismo nombre, PDO::FETCH_ASSOC devuelve solo un valor por nombre de columna. */
	final public static  function getConnection()
	{
		


		try {
			$opt = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

			$dsn = new PDO(self::$host, self::$user, self::$password, $opt);

			$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			error_log('conexion exitosa');

			return $dsn;
		} catch (\PDOException $e2) {
			error_log('Error de conexion :' . $e2);
			die(json_encode(ResponseHttp::status500(CE_500)));
		}
	}
}
