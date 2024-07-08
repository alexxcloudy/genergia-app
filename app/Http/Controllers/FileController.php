<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function uploadCsv(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048' // Máximo 2MB
        ]);

        // // Verificar si el archivo es válido
        // if ($request->file('file')->isValid()) {
        //     // Guardar el archivo
        //     $path = $request->file('file')->store('csv_files', 'public');

        //     if ($path) {
        //         return response()->json(['message' => 'File uploaded successfully', 'path' => $path], 200);
        //     } else {
        //         return response()->json(['message' => 'File upload failed'], 500);
        //     }
        // }
        // Obtener el archivo
        $file = $request->file('file');
        Log::info('File received: ' . $file->getClientOriginalName());

        // Definir la ruta de almacenamiento
        $filePath = 'uploads/csv';
        $fileName = time() . '-' . $file->getClientOriginalName();

        // Mover el archivo a la ruta de almacenamiento
        try {
            $file->storeAs($filePath, $fileName);
            Log::info('File stored at: ' . $filePath . '/' . $fileName);

            // Devolver respuesta
            return response()->json([
                'message' => 'File uploaded successfully.',
                'path' => $filePath . '/' . $fileName
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing file: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error uploading file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
