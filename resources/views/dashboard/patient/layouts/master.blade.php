<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Patient | @yield('page-title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans text-gray-900">

<div class="flex h-screen overflow-hidden">
    <aside class="w-72 bg-gradient-to-b from-blue-900 to-blue-800 text-white flex flex-col shadow-2xl">
        <div class="p-6 text-2xl font-bold border-b border-blue-700 flex items-center gap-3">
            <i class="fas fa-heartbeat text-blue-400"></i>
            <span>PatientCare</span>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('patient.dashboard') ? 'bg-blue-600 shadow-lg' : 'hover:bg-blue-700' }}">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
            <a href="{{ route('patient.rdv.create') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-700 transition">
                <i class="fas fa-calendar-plus"></i> Prendre RDV
            </a>
            <a href="{{ route('patient.consultations.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-700 transition">
                <i class="fas fa-file-medical"></i> Consultations
            </a>
            <a href="{{ route('patient.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-700 transition">
                <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-700">@yield('page-title')</h1>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-medium">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
                        <p class="text-xs text-gray-500">Patient</p>
                    </div>
                    
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-10 h-10 rounded-full border-2 border-blue-100 object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->prenom }}+{{ auth()->user()->nom }}&background=0284c7&color=fff" class="w-10 h-10 rounded-full border-2 border-blue-100">
                    @endif
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                        <i class="fas fa-sign-out-alt text-lg"></i>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>