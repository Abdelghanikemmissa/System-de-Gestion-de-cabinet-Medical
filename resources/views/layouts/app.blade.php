<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>MediPlus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="container mx-auto">
            <span class="font-bold">MedicalPlus</span>
        </div>
    </nav>

    <main class="container mx-auto mt-6">
        @yield('content')
    </main>
</body>
</html> -->
<!-- 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | MaClinique Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animate-up { animation: fadeInUp 0.6s ease-out forwards; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800">

    <div class="flex h-screen overflow-hidden">
        <aside class="w-72 bg-white border-r border-slate-200 hidden lg:flex flex-col z-20">
            <div class="p-8 flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <i class="fas fa-stethoscope text-white text-xl"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900 uppercase">Ma<span class="text-blue-600">Clinique</span></span>
            </div>

            <nav class="flex-1 px-6 space-y-2">
                <a href="{{ route('medecin.index') }}" class="flex items-center gap-3 px-4 py-3 {{ Request::routeIs('medecin.index') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl font-bold transition-all">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
                <a href="{{ route('medecin.planning') }}" class="flex items-center gap-3 px-4 py-3 {{ Request::routeIs('medecin.planning') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl font-bold transition-all">
                    <i class="fas fa-calendar-alt"></i> Mon Planning
                </a>
                <a href="{{ route('medecin.patients') }}" class="flex items-center gap-3 px-4 py-3 {{ Request::routeIs('medecin.patients') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl font-bold transition-all">
                    <i class="fas fa-user-injured"></i> Patients
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition-all">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-10 shrink-0 shadow-sm z-10">
                <form action="{{ route('medecin.recherche') }}" method="GET" class="relative w-96">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                    <input type="text" name="cni" placeholder="Chercher CNI..." class="w-full bg-slate-50 border-none rounded-2xl py-2.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
                </form>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-black text-slate-900">Dr. {{ auth()->user()->nom }}</p>
                        <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest italic">En ligne</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold shadow-lg shadow-blue-100 uppercase">
                        {{ substr(auth()->user()->nom, 0, 1) }}
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-10">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPlus | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-72 bg-white border-r border-slate-200 flex flex-col shrink-0">
        <div class="p-8 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 text-white">
                <i class="fas fa-stethoscope text-xl"></i>
            </div>
            <span class="text-xl font-extrabold text-slate-900 uppercase tracking-tighter">Medi<span class="text-blue-600">Plus</span></span>
        </div>

        <nav class="flex-1 px-6 space-y-2">
            <a href="{{ route('medecin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all {{ Request::routeIs('medecin.index') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }}">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
            <a href="{{ route('medecin.patients') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all {{ Request::routeIs('medecin.patients') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50' }}">
                <i class="fas fa-user-injured"></i> Mes Patients
            </a>
        </nav>

        <div class="p-6 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 w-full text-red-500 font-bold hover:bg-red-50 rounded-xl transition-all">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0">
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-10">
            <form action="{{ route('medecin.recherche') }}" method="GET" class="relative w-96">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" name="cni" placeholder="Chercher un patient par CNI..." 
                       class="w-full bg-slate-50 border-none rounded-2xl py-2.5 pl-12 pr-4 focus:ring-2 focus:ring-blue-500 text-sm outline-none">
            </form>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-sm font-black text-slate-900 italic">Dr. {{ auth()->user()->nom }}</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest italic">Actif</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-100 border-2 border-blue-600 flex items-center justify-center text-blue-600 font-bold">
                    {{ substr(auth()->user()->nom, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10">
            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 font-bold border border-red-100">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </main>

</body>
</html> -->


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