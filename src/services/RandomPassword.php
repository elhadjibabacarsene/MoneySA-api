<?php


namespace App\services;


class RandomPassword
{

    /**
     * Permet de générer un password aléatoirement
     *
     * @param int $taillePassword
     * @return string
     */
    public function generate(int $taillePassword)
    {
        $elements = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#$!%*?&';
        $password = array();
        for($i=0; $i<$taillePassword; $i++){
            $temp = rand(0, strlen($elements) - 1);
            $password[] = $elements[$temp];
        }
        return implode($password);
    }

}