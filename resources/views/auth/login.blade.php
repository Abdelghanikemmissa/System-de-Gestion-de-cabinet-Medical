<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f8fafc] flex items-center justify-center h-screen">

    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md border border-slate-100">
        <div class="text-center mb-10">
            <div class="bg-emerald-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Bienvenue</h1>
            <p class="text-slate-500 mt-2">Accédez à votre espace secrétariat</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
                <input type="email" name="email" required placeholder="nom@exemple.com"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition-all">
            </div>

            <button type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-200 transition duration-300 transform hover:-translate-y-1">
                Se connecter
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-slate-600 text-sm">
                Pas encore de compte ? 
                <a href="#" class="text-emerald-600 font-bold hover:text-emerald-700 hover:underline transition-colors ml-1">
                    S'inscrire
                </a>
            </p>
        </div>
        
    </div>

</body>
</html>