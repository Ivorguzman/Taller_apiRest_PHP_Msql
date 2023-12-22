
<?php
/* El código define constantes  para representar códigos de estado HTTP. Estas constantes se
pueden utilizar en todo el código PHP para indicar el resultado de una solicitud. A cada constante
se le asigna un valor de cadena que representa el mensaje de estado HTTP correspondiente. Por
ejemplo, a la constante `CE_200` se le asigna el valor "Ok". que representa el código de estado HTTP
200. */
define("CE_200", "Opracion exitosa: ");
define("CE_204", "Petición Procesada: ");

define("CE_400", "Peticion Incorrecta: ");
define("CE_401", "No tiene privilegios para acceder recursos solicitados:  ");
define("CE_403", "No esta autorizado para solicitar este recurso: ");
define("CE_404", "Problema con algun recurso:  ");
define("CE_410", "El recurso ya no existe: ");
define("CE_422", "Datos incorrectos Corrige e intenta de nuevo: ");

define("CE_500", "Error Interno:  ");
define("CE_502", "No se que Paso: ");
define("CE_503", "Recurso no disponible: ");
define("CE_504", "Servidor tardo mucho en responder: ");

?>
