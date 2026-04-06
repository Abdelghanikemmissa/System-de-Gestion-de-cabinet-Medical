<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Barryvdh\DomPDF\Facade\Pdf;

class Ordonnance extends Model
{
    protected $fillable = ['id', 'consultation_id', 'contenu'];

    public function genererDocumentPDF(){
    // Sécurité N+1 et vérification des relations
        if (!$this->consultation || !$this->consultation->dossier) {
            throw new \Exception("Données de consultation incomplètes.");
        }

        $data = [
            'ordonnance' => $this,
            'patient'    => $this->consultation->dossier->patient->user ?? null,
            'medecin'    => $this->consultation->rendezvous->medecin->user ?? null,
            'date'       => $this->created_at ? $this->created_at->format('d/m/Y') : date('d/m/Y'),
        ];

            $pdf = Pdf::loadView('pdf.ordonnance', $data);

            return $pdf->stream("ordonnance_{$this->id}.pdf");
        }

        public function consultation(){
            return $this->belongsTo(Consultation::class, 'consultation_id');
        }
}