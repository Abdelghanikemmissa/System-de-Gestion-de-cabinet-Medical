<?php
namespace App\Http\Controllers;

use App\Models\Ordonnance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    public function exportPDF($id)
    {
        // On récupère l'ordonnance ou on renvoie une 404 si elle n'existe pas
        $ordonnance = Ordonnance::findOrFail($id);
        
        // On appelle la méthode du modèle qui génère et renvoie le stream directement
        return $ordonnance->genererDocumentPDF();
    }
}