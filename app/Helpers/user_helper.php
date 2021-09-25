<?php

function hashPassword($plainPassword){
   

/**
 * Queremos crear un hash de nuestra contraseña uando el algoritmo DEFAULT actual.
 * Actualmente es BCRYPT, y producirá un resultado de 60 caracteres.
 *
 * Hay que tener en cuenta que DEFAULT puede cambiar con el tiempo, por lo que debería prepararse
 * para permitir que el almacenamento se amplíe a más de 60 caracteres (255 estaría bien)
 */

    return password_hash($plainPassword, PASSWORD_DEFAULT);
}

function verificarPassword($plainPassword,$hashPassword){

    return password_verify($plainPassword,$hashPassword);

}
