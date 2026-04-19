<!DOCTYPE html>
<html>
<body>
    <h1>Bonjour {{ $user->prenom }},</h1>
    <p>Votre compte patient a bien été créé au sein de notre cabinet.</p>
    <p>Vous pouvez maintenant vous connecter avec votre email : <strong>{{ $user->email }}</strong></p>
    <br>
    <p>Cordialement,<br>L'équipe médicale</p>
</body>
</html>