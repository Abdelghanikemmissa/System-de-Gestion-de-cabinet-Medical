<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Patient</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen p-10">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border">
        <h2 class="text-2xl font-bold mb-6 text-slate-800">Ajouter un nouveau patient</h2>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm">
                <ul>@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
            </div>
        @endif
        
        <form action="{{ route('secretaire.ajouter') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <input type="text" name="nom" placeholder="Nom" class="w-full p-4 border rounded-xl" required>
                <input type="text" name="prenom" placeholder="Prénom" class="w-full p-4 border rounded-xl" required>
                <input type="text" name="cni" placeholder="Numéro CNI" class="w-full p-4 border rounded-xl" required>
                <input type="email" name="email" placeholder="Email" class="w-full p-4 border rounded-xl" required>
                <input type="tel" name="telephone" placeholder="Téléphone" class="w-full p-4 border rounded-xl" required>
                <input type="date" name="date_naissance" class="w-full p-4 border rounded-xl" required>
                <select name="sexe" class="w-full p-4 border rounded-xl bg-white">
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            <textarea name="adresse" placeholder="Adresse complète" class="w-full p-4 border rounded-xl" rows="3" required></textarea>
            
            <div class="flex gap-4">
                <a href="{{ route('secretaire.dashboard') }}" class="flex-1 text-center bg-slate-100 p-4 rounded-xl font-bold text-slate-600 hover:bg-slate-200">Annuler</a>
                <button type="submit" class="flex-1 bg-emerald-500 text-white font-bold p-4 rounded-xl hover:bg-emerald-600 transition">
                    Enregistrer le Patient
                </button>
            </div>
        </form>
    </div>
</body>
</html>