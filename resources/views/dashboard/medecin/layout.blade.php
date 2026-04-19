<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | MediCare</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-slate-50 text-slate-800">

<div class="flex min-h-screen">

    <aside class="w-72 bg-white border-r border-slate-100 flex flex-col fixed h-full shadow-sm z-50">

        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center text-white">
                <i class="fas fa-stethoscope"></i>
            </div>
            <h1 class="text-xl font-black tracking-tight">MediCare</h1>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            @php
                $menu = [
                    ['Tableau de bord', 'fa-th-large', 'medecin.index'],
                    ['Rendez-vous', 'fa-calendar', 'medecin.planning'],
                    ['Patients', 'fa-user-injured', 'medecin.patients'],
                ];
            @endphp

            @foreach($menu as $item)
                @php $isActive = $item[2] && request()->routeIs($item[2]); @endphp
                
                <a href="{{ $item[2] ? route($item[2]) : '#' }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition {{ $isActive ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'hover:bg-slate-100 text-slate-600' }}">
                    <i class="fas {{ $item[1] }}"></i>
                    {{ $item[0] }}
                </a>
            @endforeach
            <a href="{{ route('medecin.dispo.index') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-blue-50 rounded-xl">
                📅 Gérer mes disponibilités
            </a>
        </nav>

        <div class="p-4 border-t bg-slate-50">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://i.pravatar.cc/40?u='.auth()->user()->id }}" 
                class="rounded-full w-10 h-10 border-2 border-white shadow-sm">
                <div>
                    <p class="text-sm font-bold">Dr. {{ auth()->user()->nom }}</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider">En ligne</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 text-red-500 hover:bg-red-50 px-4 py-2 rounded-xl font-bold transition">
                    <i class="fas fa-right-from-bracket"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 ml-72">

        <header class="bg-white/80 backdrop-blur-md sticky top-0 border-b px-8 py-4 flex justify-between items-center z-40">
            <h2 class="text-xl font-black text-slate-800">@yield('title')</h2>

            <div class="flex items-center gap-6">
                <div class="relative cursor-pointer hover:text-blue-600 transition">
                    <i class="fas fa-bell text-lg text-slate-400"></i>
                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </div>
                <a href="{{ route('medecin.profile.show') }}" class="flex items-center gap-3 mb-4 hover:bg-slate-100 p-2 rounded-xl transition">
    <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://i.pravatar.cc/40?u='.auth()->user()->id }}" 
         class="rounded-full w-10 h-10 border-2 border-white shadow-sm">
    <div>
        <p class="text-sm font-bold">Dr. {{ auth()->user()->nom }}</p>
        <p class="text-[10px] text-blue-500 font-bold uppercase tracking-wider underline">Modifier mon profil</p>
    </div>
</a>
            </div>
        </header>

        <div class="p-8">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>