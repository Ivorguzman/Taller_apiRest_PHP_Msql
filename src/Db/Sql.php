<?php

namespace App\DB;

use App\Config\ResponseHttp;

/* La `clase Sql extiende ConnectionDb` está creando una nueva clase llamada `Sql` que extiende la
clase `ConnectionDb`. Esto significa que la clase `Sql` hereda todas las propiedades y métodos de la
clase `ConnectionDb`. */

class Sql extends ConnectionDb
{

	/**
	 * La función verifica si existe un registro en una tabla de base de datos según una condición y un  parámetro determinados.
	 * @param 'string  request 'El parámetro "request" es una cadena que representa la consulta SQL que  desea ejecutar. Debe ser una declaración SQL válida que pueda ser ejecutada por la base de datos.
	 * @param 'string condition' El parámetro "condición" es una cadena que representa el nombre de la  columna en la tabla de la base de datos cuya existencia desea verificar.
	 * @param ' param ' Es un valor que se utilizará en la consulta para verificar si existe un registro en la base de datos. Puede ser de cualquier tipo de datos, dependiendo de la columna que esté comparando.
	 * @return 'response' valor booleano. Devuelve verdadero si la consulta se ejecutó correctamente y devolvió al  menos una fila, lo que indica que se cumple la condición. Devuelve falso si la consulta se ejecutó correctamente pero no devolvió ninguna fila, lo que indica que no se cumple la condición.
	 * 
	 *  El bloque `catch (\PDOException )` se utiliza para detectar cualquier excepción 	que pueda ocurrir durante la ejecución del código dentro del bloque `try`. En este caso, detecta específicamente excepciones de tipo "PDOException", que están relacionadas con errores de labase de datos.
	 *
	 * `die(json_encode(ResponseHttp::status500(CE_500)));` es una declaración que finaliza la ejecución	del script y genera una respuesta codificada en JSON con un código de estado 500. 
	 */
	/* El método `->execute()` se utiliza para ejecutar una declaración preparada con los
			  parámetros dados. En este caso, los parámetros se pasan como una matriz asociativa donde la clave 	es el nombre de la columna (`condition`) y el valor es el valor del parámetro (`param`). Esto permite que la declaración preparada se ejecute con los valores especificados para la condición 	dada. */
	public static function existe(string $request, string $condition, $param) //OjO Cambiar nombres
	{

		// // //  print("Prueba sql.php");
		// // // //// var_dump('$request ===> ' . $request);
		// // // //// var_dump('$condition ===> ' . $condition);
		// // // //// var_dump('$param ===> ' . $param);

		try {
			$conn = self::getConnection();
			$pStm = $conn->prepare($request);

			/* La línea ` = array( => );` está creando un array
			asociativo donde la clave es el valor de la variable `$condition` y el valor es el valor de la
			variable `$param`. Luego, esta matriz se pasa como parámetro al método `execute()` de la
			declaración preparada. Esto permite que la declaración preparada se ejecute con los valores
			especificados para la condición dada. */
			$asignar_valores_parametros = array($condition => $param);
			$pStm->execute($asignar_valores_parametros);


			$response = ($pStm->rowCount() == 0) ? false : true;

			return $response;
		} catch (\PDOException $PDOex) {
			error_log('Sql::exist ->' . $PDOex->getMessage());
			die(json_encode(ResponseHttp::status500(CE_500 . "No existe registro")));
		}
	}
}
