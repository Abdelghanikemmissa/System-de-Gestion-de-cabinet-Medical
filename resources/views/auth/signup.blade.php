<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Cabinet Médical</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 bg-white rounded-3xl shadow-2xl overflow-hidden">

    <!-- IMAGE GAUCHE (identique login) -->
    <div class="hidden md:block relative h-full min-h-[500px]">
        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=1974&auto=format&fit=crop"
             class="w-full h-full object-cover"
             onerror="this.src='https://via.placeholder.com/600x800';" />

        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/70 to-blue-600/60"></div>

        <div class="absolute bottom-10 left-10 text-white">
            <h2 class="text-3xl font-extrabold mb-2">Rejoignez-nous 👋</h2>
            <p class="text-sm opacity-90">Créez votre espace médical sécurisé</p>
        </div>
    </div>

    <!-- FORMULAIRE -->
    <div class="p-10 bg-white/80 backdrop-blur-xl">

        <div class="text-center mb-8">
            <div class="bg-emerald-500 text-white p-4 rounded-full shadow-lg inline-block mb-3">
                <i class="fas fa-user-plus text-xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800">Inscription</h1>
            <p class="text-slate-500 text-sm">Créez votre compte patient</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('signup.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="nom" placeholder="Nom"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>

                <input type="text" name="prenom" placeholder="Prénom"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>
            </div>

            <input type="email" name="email" placeholder="Email"
                   class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>

            <input type="password" name="password" placeholder="Mot de passe"
                   class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>

            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="cni" placeholder="CNI"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>

                <input type="tel" name="telephone" placeholder="Téléphone"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <input type="date" name="date_naissance"
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" required>

                <select name="sexe"
                        class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none">
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>

            <textarea name="adresse" placeholder="Adresse"
                      class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none"
                      rows="2"></textarea>

            <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-emerald-200">
                Créer mon compte
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">
                Connectez-vous
            </a>
        </div>

    </div>
</div>

</body>
</html>