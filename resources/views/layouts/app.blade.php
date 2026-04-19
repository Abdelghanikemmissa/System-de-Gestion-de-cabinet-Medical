
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPlus Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4f8; }
        .glass-card { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .sidebar-active { background: #2563eb; color: white; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3); }
    </style>
</head>
<body class="flex h-screen p-4 gap-4">

    <aside class="w-72 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 flex flex-col p-6 border border-white/50">
        <div class="flex items-center gap-3 px-4 py-8">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="fas fa-heart-pulse text-xl"></i>
            </div>
            <span class="text-xl font-extrabold text-slate-800 tracking-tight">Medi<span class="text-blue-600">Plus</span></span>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('medecin.index') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ Request::routeIs('medecin.index') ? 'sidebar-active' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-grid-2 text-lg"></i> Dashboard
            </a>
            <a href="{{ route('medecin.patients') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ Request::routeIs('medecin.patients') ? 'sidebar-active' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-user-group text-lg"></i> Patients
            </a>
            <a href="{{ route('medecin.planning') }}" class="flex items-center gap-4 px-6 py-4 rounded-2xl font-bold transition-all {{ Request::routeIs('medecin.planning') ? 'sidebar-active' : 'text-slate-400 hover:text-slate-600' }}">
                <i class="fas fa-calendar-days text-lg"></i> Calendrier
            </a>
        </nav>

        <div class="mt-auto p-4 bg-slate-50 rounded-3xl border border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">DR</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">Dr. {{ auth()->user()->nom }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Médecin Généraliste</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col gap-4 overflow-hidden">
        <header class="h-20 bg-white/70 backdrop-blur-md rounded-[2rem] shadow-sm border border-white px-8 flex items-center justify-between">
            <div class="relative w-96">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" placeholder="Rechercher un dossier, CNI..." class="w-full bg-slate-100/50 border-none rounded-2xl py-2.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500/20 text-sm italic">
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 flex items-center justify-center hover:text-blue-600 transition-colors">
                    <i class="fas fa-bell"></i>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto px-2">
            @yield('content')
        </div>
    </main>

</body>
</html>