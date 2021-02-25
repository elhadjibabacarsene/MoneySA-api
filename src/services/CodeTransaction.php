<?php


namespace App\services;


class CodeTransaction
{
    function generate(){
        return  date("s").date("m").date("Y").date("H").date("i");
    }
}