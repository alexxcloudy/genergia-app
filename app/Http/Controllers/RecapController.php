<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RecapController extends Controller
{
    public function getData()
    {
         // Ruta al archivo JSON (asegúrate de que el archivo 'objeto.json' exista en la carpeta 'public')
         $jsonFilePath = storage_path('app/public/recap.json');

         if (File::exists($jsonFilePath)) {
             // Lee el contenido del archivo JSON
             $jsonData = File::get($jsonFilePath);

             // Decodifica el contenido como un array asociativo
             $data = json_decode($jsonData, true);

             // Devuelve los datos como una respuesta JSON
             return response()->json($data);
         } else {
             // Si el archivo no existe, devuelve una respuesta de error
             return response()->json(['error' => 'El archivo objeto.json no se encontró'], 404);
         }
    }
}
