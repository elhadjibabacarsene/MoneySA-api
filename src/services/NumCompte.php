<?php


namespace App\services;


class NumCompte
{
    /**
     * Fonction quu nous permet de générer un numéro de compte aléatoirement
     * @return string
     */
    public function generate()
    {
        return strtoupper(uniqid('C'));
    }
}