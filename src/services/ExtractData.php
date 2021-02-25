<?php


namespace App\services;


use Symfony\Component\HttpFoundation\Request;

class ExtractData
{
    /**
     * Permet d'extraire des données depuis une request
     * @param Request $request
     * @return array
     */
    public function extract(Request $request)
    {
        $contentRequest = $request->getContent();
        //le tableau qui contiendra les données extraites
        $extracData = [];
        //On éclate la chaine
        $data = preg_split("/form-data; /", $contentRequest);
        //On supprime le premier élément du tableau
        unset($data[0]);
        foreach ($data as $item) {
            $data2 = preg_split("/\r\n/", $item);
            array_pop($data2);
            array_pop($data2);
            $key = explode('"', $data2[0]);
            $key = $key[1];
            $extracData[$key] = end($data2);
        }
        return $extracData;
    }
}