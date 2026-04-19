<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Barryvdh\DomPDF\Facade\Pdf;

class Ordonnance extends Model
{
    protected $fillable = ['id', 'consultation_id', 'contenu'];

    public function genererDocumentPDF()
{
    // Charger les relations nécessaires pour éviter les erreurs de null
    $this->load(['consultation.rendezvous.medecin.user', 'consultation.dossier.patient.user']);

    $consultation = $this->consultation;
    $dossier = $consultation->dossier ?? null;
    $rendezvous = $consultation->rendezvous ?? null;

    if (!$dossier || !$dossier->patient) {
        throw new \Exception("Dossier médical ou patient introuvable pour cette ordonnance.");
    }

    $data = [
        'ordonnance' => $this,
        'patient'    => $dossier->patient->user ?? null,
        'medecin'    => $rendezvous->medecin->user ?? null,
        'date'       => $this->created_at ? $this->created_at->format('d/m/Y') : date('d/m/Y'),
    ];

    $pdf = Pdf::loadView('pdf.ordonnance', $data);
    return $pdf->stream("ordonnance_{$this->id}.pdf");
}

        public function consultation(): BelongsTo
{
    return $this->belongsTo(Consultation::class, 'consultation_id');
}
}