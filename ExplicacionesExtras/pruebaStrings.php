<?php
$strSql = "SELECT password FROM usuario WHERE IDToken = :IDToken
VALUES  (:nombre, :dni, :email, :password, :IDToken, :fecha) ";
print_r($strSql);
/*

{
	"name":"hugo",
	"dni":"123",
	"email":"prueba@prueba.com",
	"rol": "2",
	"password":"12345678",
	"confirmPassword":"12345678"
}



*/





