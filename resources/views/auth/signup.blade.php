<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-emerald-100 via-blue-100 to-slate-200 min-h-screen py-10 flex items-center justify-center">

    <div class="w-full max-w-lg p-8 bg-white/70 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30">
        <div class="text-center mb-8">
            <div class="bg-blue-500 text-white p-4 rounded-full shadow-lg inline-block mb-3">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800">Inscription Patient</h1>
            <p class="text-slate-500 text-sm">Créez votre dossier médical</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('signup.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="nom" placeholder="Nom" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
                <input type="text" name="prenom" placeholder="Prénom" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
            </div>
            
            <input type="email" name="email" placeholder="Adresse Email" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
            <input type="password" name="password" placeholder="Mot de passe" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
            
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="cni" placeholder="Numéro CNI" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
                <input type="tel" name="telephone" placeholder="Téléphone" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <input type="date" name="date_naissance" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" required>
                <select name="sexe" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none">
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            
            <textarea name="adresse" placeholder="Adresse complète" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none" rows="2"></textarea>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-blue-200 mt-4">
                Créer mon compte
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            Déjà inscrit ? 
            <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Connectez-vous</a>
        </div>
    </div>
</body>
</html>