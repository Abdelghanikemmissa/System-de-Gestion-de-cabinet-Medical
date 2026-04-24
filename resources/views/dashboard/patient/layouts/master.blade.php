<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Patient | @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="text-gray-900 font-sans">

<!-- Background -->
<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1580281657527-47e9d6c86c1b?q=80&w=1974&auto=format&fit=crop"
         class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-slate-900/80 to-slate-800/90"></div>
</div>

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-72 bg-white/10 backdrop-blur-xl border-r border-white/10 text-white flex flex-col shadow-2xl">

        <div class="p-6 text-2xl font-bold border-b border-white/10 flex items-center gap-3">
            <i class="fas fa-heartbeat text-blue-300"></i>
            <span>PatientCare</span>
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="{{ route('patient.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->routeIs('patient.dashboard') ? 'bg-blue-600 shadow-lg' : 'hover:bg-white/10' }}">
                <i class="fas fa-home"></i> Tableau de bord
            </a>

            <a href="{{ route('patient.rdv.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
                <i class="fas fa-calendar-plus"></i> Prendre RDV
            </a>

            <a href="{{ route('patient.consultations.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
                <i class="fas fa-file-medical"></i> Consultations
            </a>

            <a href="{{ route('patient.profile.edit') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition">
                <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>

        </nav>

    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col overflow-hidden">

        <!-- Header -->
        <header class="bg-white/10 backdrop-blur-xl border-b border-white/10 px-8 py-4 flex justify-between items-center text-white">

            <h1 class="text-xl font-semibold">
                @yield('page-title')
            </h1>

            <div class="flex items-center gap-6">

                <div class="text-right">
                    <p class="text-sm font-medium">
                        {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                    </p>
                    <p class="text-xs text-white/70">Patient</p>
                </div>

                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                         class="w-10 h-10 rounded-full border border-white/30 object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->prenom }}+{{ auth()->user()->nom }}&background=0284c7&color=fff"
                         class="w-10 h-10 rounded-full border border-white/30">
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-300 hover:text-red-400 transition">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>

            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-8">

            @if(session('success'))
                <div class="bg-green-500/20 text-green-200 p-4 rounded-xl mb-6 border border-green-400/30 backdrop-blur">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

</body>
</html>