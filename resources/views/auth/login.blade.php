<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-emerald-100 via-blue-100 to-slate-200 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-white/70 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/30">
        <div class="text-center mb-8">
            <div class="bg-emerald-500 text-white p-4 rounded-full shadow-lg inline-block mb-3">
                <i class="fas fa-stethoscope text-xl"></i>
            </div>
            <h1 class="text-2xl font-black text-slate-800">Cabinet Médical</h1>
            <p class="text-slate-500 text-sm">Accès à votre espace</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-4 text-sm border border-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-3 rounded-lg mb-4 text-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Email</label>
                <input type="email" name="email" required class="w-full pl-4 pr-4 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" placeholder="votre.email@exemple.com">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">Mot de passe</label>
                <input type="password" name="password" required class="w-full pl-4 pr-4 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-400 outline-none" placeholder="••••••••">
            </div>

            <div class="flex justify-between items-center text-sm">
                <label class="flex items-center gap-2 text-slate-600">
                    <input type="checkbox" name="remember" class="rounded text-emerald-600"> Se souvenir de moi
                </label>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-emerald-200">
                Se connecter
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600">
            Pas encore de compte ? 
            <a href="{{ route('signup') }}" class="text-blue-600 font-bold hover:underline">Inscrivez-vous ici</a>
        </div>
    </div>
</body>
</html>