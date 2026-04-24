<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediPlus - Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Inter', sans-serif; }
.hidden { display:none !important; }
</style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 flex min-h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white/90 backdrop-blur border-r border-blue-100 p-6 flex flex-col shadow-sm">
    <div class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-green-400 rounded-xl flex items-center justify-center text-white font-bold">M+</div>
        <span class="text-lg font-semibold text-slate-800">MediPlus</span>
    </div>

    <nav class="flex flex-col gap-2">
        <button onclick="switchTab('stats')" id="nav-stats" class="nav-link p-3 rounded-xl bg-gradient-to-r from-blue-500 to-green-400 text-white font-medium shadow-sm">Dashboard</button>
        <button onclick="switchTab('medecin')" id="nav-medecin" class="nav-link p-3 rounded-xl text-slate-600 hover:bg-blue-50 transition">👨‍⚕️ Médecins</button>
        <button onclick="switchTab('secretaire')" id="nav-secretaire" class="nav-link p-3 rounded-xl text-slate-600 hover:bg-blue-50 transition">📝 Secrétaires</button>
    </nav>

    <div class="mt-auto text-xs text-slate-400 pt-10">MediPlus</div>
</aside>

<!-- Main -->
<main class="flex-1 p-10">
    <h1 id="main-title" class="text-3xl font-bold text-slate-800 mb-8">Tableau de bord</h1>

    <!-- Stats -->
    <div id="view-stats" class="space-y-8">

        <!-- Cards -->
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Médecins</p>
                <h2 class="text-2xl font-bold text-blue-600">{{ $stats['total_medecins'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Secrétaires</p>
                <h2 class="text-2xl font-bold text-green-500">{{ $stats['total_secretaires'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Rendez-vous</p>
                <h2 class="text-2xl font-bold text-slate-700">{{ $stats['total_rdv'] }}</h2>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <h3 class="font-semibold text-slate-700 mb-4">Personnel</h3>
                <canvas id="barChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <h3 class="font-semibold text-slate-700 mb-4">Rendez-vous</h3>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div id="view-form" class="hidden">
        <div class="max-w-2xl bg-white p-8 rounded-2xl shadow-sm border border-blue-100">
            <h2 class="text-xl font-semibold text-slate-800 mb-6">Ajouter un membre</h2>

            <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Nom" class="input">
                <input type="text" placeholder="Prénom" class="input">
                <input type="email" placeholder="Email professionnel" class="input">
                <input type="text" placeholder="CNI" class="input">
                <input type="password" placeholder="Mot de passe" class="input col-span-2">

                <div id="specialite-field" class="col-span-2">
                    <input type="text" placeholder="Spécialité médicale" class="input w-full">
                </div>

                <button class="col-span-2 bg-gradient-to-r from-blue-500 to-green-400 text-white py-3 rounded-xl font-medium hover:opacity-90 transition">
                    Confirmer
                </button>
            </form>
        </div>
    </div>
</main>

<style>
.input {
    background:#f8fafc;
    padding:12px;
    border-radius:10px;
    border:1px solid #e2e8f0;
}
.input:focus {
    outline:none;
    border-color:#3b82f6;
    background:white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Médecins', 'Secrétaires'],
            datasets: [{ data: [{{ $stats['total_medecins'] }}, {{ $stats['total_secretaires'] }}] }]
        }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Confirmés', 'Autres'],
            datasets: [{ data: [{{ $stats['rdv_confirmes'] }}, {{ $stats['total_rdv'] - $stats['rdv_confirmes'] }}] }]
        }
    });
});

function switchTab(type) {
    document.getElementById('view-stats').classList.add('hidden');
    document.getElementById('view-form').classList.add('hidden');

    document.querySelectorAll('.nav-link').forEach(btn => {
        btn.classList.remove('bg-gradient-to-r','from-blue-500','to-green-400','text-white');
    });

    if (type === 'stats') {
        document.getElementById('view-stats').classList.remove('hidden');
        document.getElementById('nav-stats').classList.add('bg-gradient-to-r','from-blue-500','to-green-400','text-white');
        document.getElementById('main-title').innerText = 'Tableau de bord';
    } else {
        document.getElementById('view-form').classList.remove('hidden');
        document.getElementById('main-title').innerText = type === 'medecin' ? 'Médecins' : 'Secrétaires';

        if (type === 'medecin') {
            document.getElementById('specialite-field').classList.remove('hidden');
        } else {
            document.getElementById('specialite-field').classList.add('hidden');
        }
    }
}
</script>

</body>
</html>
