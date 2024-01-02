<?php

use App\Db\dataDB;
use App\Db\ConnectionDb;
// use Dotenv\Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

/* La matriz `$conexion` define los detalles de conexión para una base de datos. Incluye los siguientes
pares clave-valor: */
$data = array(
	'user' => $_ENV['USER'],
	'password' => $_ENV['PASSWORD'],
	'db' => $_ENV['DB'],
	'ip' => $_ENV['IP'],
	'port' => $_ENV['PORT'],
);

// //// var_dump($data['ip']);
// //// var_dump($data['port']);
// //// var_dump($data['db']);
// //// var_dump($data['user']);
// //// var_dump($data['password']);

$host = 'mysql:host=' . $data['ip'] . ';' . 'port=' . $data['port'] . ';' . 'dbname=' . $data['db'];


ConnectionDB::from($host, $data['user'], $data['password']);
