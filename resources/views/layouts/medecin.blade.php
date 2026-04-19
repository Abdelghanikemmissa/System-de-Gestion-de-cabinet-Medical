<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPlus - Espace Docteur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex min-h-screen">

    <aside class="w-72 bg-blue-900 text-white flex flex-col fixed h-full shadow-2xl">
        <div class="p-8 text-center border-b border-blue-800">
            <h1 class="text-2xl font-black tracking-tighter">
                <i class="fas fa-heartbeat mr-2 text-blue-400"></i>MEDIPLUS
            </h1>
            <p class="text-xs text-blue-300 mt-1 uppercase tracking-widest">Espace Médical</p>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('medecin.index') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('medecin.index') ? 'bg-blue-700 shadow-lg' : 'hover:bg-blue-800' }}">
                <i class="fas fa-th-large w-8 text-lg"></i>
                <span class="font-medium">Tableau de bord</span>
            </a>

            <a href="{{ route('medecin.patients') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('medecin.patients') ? 'bg-blue-700 shadow-lg' : 'hover:bg-blue-800' }}">
                <i class="fas fa-user-injured w-8 text-lg"></i>
                <span class="font-medium">Mes Patients</span>
            </a>

            <a href="{{ route('medecin.planning') }}" 
               class="flex items-center p-3 rounded-xl transition {{ request()->routeIs('medecin.planning') ? 'bg-blue-700 shadow-lg' : 'hover:bg-blue-800' }}">
                <i class="fas fa-calendar-alt w-8 text-lg"></i>
                <span class="font-medium">Planning & Dispo</span>
            </a>

            <div class="pt-4 pb-2 px-3 text-xs font-bold text-blue-400 uppercase tracking-widest">Consultations</div>

            <a href="#" class="flex items-center p-3 rounded-xl hover:bg-blue-800 transition">
                <i class="fas fa-history w-8 text-lg"></i>
                <span class="font-medium">Historique RDV</span>
            </a>
        </nav>

        <div class="p-4 border-t border-blue-800">
            <div class="flex items-center p-3 mb-4 bg-blue-950 rounded-2xl">
                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                    DR
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate">{{ Auth::user()->nom }}</p>
                    <p class="text-xs text-blue-400 truncate">Médecin</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center p-3 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition font-bold text-sm">
                    <i class="fas fa-power-off mr-2"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="ml-72 flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-gray-400 text-sm font-bold uppercase tracking-widest">Vue d'ensemble</h2>
                <p class="text-3xl font-black text-slate-800">Bienvenue, Docteur</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm font-bold text-slate-700">{{ now()->translatedFormat('d F Y') }}</p>
                    <p class="text-xs text-slate-400">Marrakech, Maroc</p>
                </div>
                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center text-blue-600 border border-slate-100">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow-sm mb-6 animate-pulse">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>