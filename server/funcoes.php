<?php

function string_db_to_upper($string){
  return mb_strtoupper(utf8_encode($string),'UTF-8');
}
function to_decimal($numero) {
  $numero = number_format($numero, 2, '.', '');
  return $numero;
}

?>