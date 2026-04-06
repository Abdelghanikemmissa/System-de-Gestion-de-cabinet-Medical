<!DOCTYPE html>
<html>
<head>
    <title>Ordonnance Médicale</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #000; margin-bottom: 20px; }
        .content { margin-top: 50px; min-height: 300px; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>CABINET MÉDICAL</h1>
        <p>Dr. {{ $ordonnance->consultation->rendezvous->medecin->user->nom }}</p>
    </div>

    <p><strong>Date :</strong> {{ $date }}</p>
    <p><strong>Patient :</strong> {{ $ordonnance->consultation->rendezvous->patient->user->nom }} {{ $ordonnance->consultation->rendezvous->patient->user->prenom }}</p>

    <div class="content">
        <h3>ORDONNANCE :</h3>
        <p>{!! nl2br(e($ordonnance->contenu)) !!}</p>
    </div>

    <div class="footer">
        <p>Cachet et Signature</p>
    </div>
</body>
</html>