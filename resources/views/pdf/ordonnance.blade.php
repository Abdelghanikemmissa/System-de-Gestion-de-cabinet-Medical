<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ordonnance Médicale</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; padding: 20px; }
        .header { border-bottom: 3px solid #2563eb; padding-bottom: 10px; margin-bottom: 30px; }
        .header h1 { color: #2563eb; margin: 0; }
        
        .patient-info { background-color: #f8fafc; padding: 15px; border-radius: 8px; border-left: 5px solid #2563eb; margin-bottom: 30px; }
        .patient-info p { margin: 5px 0; font-size: 14px; }
        
        .intro-phrase { font-style: italic; color: #64748b; margin-bottom: 20px; }
        
        .ordonnance-box { min-height: 300px; padding: 20px; border: 1px solid #e2e8f0; border-radius: 10px; }
        .ordonnance-box h3 { color: #2563eb; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; }
        
        .footer { margin-top: 50px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CABINET MÉDICAL</h1>
        <p>Dr. {{ $ordonnance->consultation->rendezvous?->medecin?->user?->nom ?? 'Médecin' }}</p>
    </div>

    <div class="patient-info">
        <p><strong>Patient :</strong> {{ $ordonnance->consultation->rendezvous?->patient?->user?->nom }} {{ $ordonnance->consultation->rendezvous?->patient?->user?->prenom }}</p>
        <p><strong>CNI :</strong> {{ $ordonnance->consultation->rendezvous?->patient?->user?->cni }}</p>
        <p><strong>Date :</strong> {{ $date }}</p>
    </div>

    <p class="intro-phrase">Veuillez trouver ci-dessous le traitement prescrit suite à votre consultation.</p>

    <div class="ordonnance-box">
        <h3>PRESCRIPTION MÉDICALE</h3>
        <p>{!! nl2br(e($ordonnance->contenu)) !!}</p>
    </div>

    <div class="footer">
        <p>Cachet et Signature</p>
    </div>
</body>
</html>