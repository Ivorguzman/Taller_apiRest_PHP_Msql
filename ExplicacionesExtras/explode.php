<?php
/*
Divide un string en varios string. Devuelve un array de string, 
siendo cada uno un substring del parámetro string 
formado por la división realizada por los delimitadores 
indicados en el parámetro string separator. 
 */
// Ejemplo 1
print_r("Ejemplo 1"."\n");
print_r("\n");
$hola = "Hola°como°estas";
$saludo = explode('°', $hola);
print('$saludo := ')."\n";
print_r($saludo);
print_r("\n");
print_r("\n");



// Ejemplo 2
print_r("Ejemplo 2" . "\n");
print_r("\n");
$pizza  = "piece1 piece2 piece3 piece4 piece5 piece6";
$pieces = explode(" ", $pizza);
print ('$pieces := ') . "\n";
print_r($pieces);

echo' $pieces[5] ¨= '; // piece2
echo $pieces[5]; // piece2
print_r("\n");
print_r("\n");



/*  Ejemplo 3 : Un string que no contiene el delimitador simplemente devolverá un array de un elemento con el string original. */
print_r(" Ejemplo 3 : Un string que no contiene el delimitador simplemente devolverá un array de un elemento con el string original." . "\n");
print_r("\n");
$input1 = "hola como estas";
print ('$input1 := ') . "\n";
print_r(explode(',', $input1));
print_r("\n");

$input2 = "hello,como estas";
print ('$input2 := ') . "\n";
print_r(explode(',', $input2));
print_r("\n");
print_r("\n");



// Ejemplo #3 Ejemplos del parámetro limit
print_r(" Ejemplo #3 Ejemplos del parámetro limit" . "\n");
print_r("\n");
$str = 'uno¬dos¬tres¬cuatro';

//limitse positivos 
print_r("limites positivos " . "\n");
print ('$str := ') . "\n";
print_r(explode('¬', $str, 1));
print_r("\n");

print ('$str := ') . "\n";
print_r(explode('¬', $str, 2));
print_r("\n");

print ('$str := ') . "\n";
print_r(explode('¬', $str, 3));
print_r("\n");

print ('$str := ') . "\n";
print_r(explode('¬', $str, 4));
print_r("\n");



//limites negativos 
print_r("limites negativos " . "\n");
print ('$str := ') . "\n";
print_r(explode('|', $str, -1));
print_r("\n");

print ('$str := ') . "\n";
print_r(explode('|', $str, -2));
print_r("\n");

print ('$str := ') . "\n";
print_r(explode('|', $str, -3));
print_r("\n");

print ('$str := ') . "\n";
print_r(explode('|', $str, -4));

?>
