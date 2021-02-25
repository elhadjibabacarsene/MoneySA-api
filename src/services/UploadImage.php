<?php


namespace App\services;


use Symfony\Component\HttpFoundation\Request;

class UploadImage
{
    /**
     * Permet d'ajouter une image lors de l'enregistrement
     *
     * @param Request $request
     * @param string $key
     */
    public function addImage(Request $request, string $key)
    {
        if ($request->files->get($key) !== null) {
            return fopen($request->files->get($key), 'rb');
        }
    }
}