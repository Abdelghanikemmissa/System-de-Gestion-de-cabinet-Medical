<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediPlus</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
<style>
body { font-family: 'Inter', sans-serif; }
.hidden { display:none !important; }
</style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 flex min-h-screen">

<!-- Sidebar -->
<aside class="w-72 bg-white/80 backdrop-blur-xl border-r border-slate-200 p-6 flex flex-col shadow-xl">
    <div class="flex items-center gap-3 mb-12">
        <div class="w-12 h-12 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-lg">M+</div>
        <span class="text-2xl font-black text-slate-800">MediPlus</span>
    </div>

    <nav class="flex flex-col gap-3">
        <button onclick="switchTab('stats')" id="nav-stats" class="nav-link flex items-center gap-3 p-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg font-semibold">
            📊 Dashboard
        </button>
        <button onclick="switchTab('medecin')" id="nav-medecin" class="nav-link p-4 rounded-2xl text-slate-600 hover:bg-slate-100 font-semibold">
            👨‍⚕️ Médecins
        </button>
        <button onclick="switchTab('secretaire')" id="nav-secretaire" class="nav-link p-4 rounded-2xl text-slate-600 hover:bg-slate-100 font-semibold">
            📝 Secrétaires
        </button>
    </nav>

    <div class="mt-auto text-sm text-slate-400 pt-10">MediPlus</div>
</aside>

<!-- Main -->
<main class="flex-1 p-10">
    <h1 id="main-title" class="text-4xl font-black text-slate-800 mb-10">Dashboard</h1>

    <!-- Stats -->
    <div id="view-stats" class="space-y-10">
        
        <!-- Cards -->
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-3xl p-6 shadow-lg">
                <p class="text-slate-500">Médecins</p>
                <h2 class="text-3xl font-black">{{ $stats['total_medecins'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-lg">
                <p class="text-slate-500">Secrétaires</p>
                <h2 class="text-3xl font-black">{{ $stats['total_secretaires'] }}</h2>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-lg">
                <p class="text-slate-500">Rendez-vous</p>
                <h2 class="text-3xl font-black">{{ $stats['total_rdv'] }}</h2>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid lg:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-3xl shadow-lg">
                <h3 class="font-bold mb-4">Personnel</h3>
                <canvas id="barChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-lg">
                <h3 class="font-bold mb-4">Rendez-vous</h3>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div id="view-form" class="hidden">
        <div class="max-w-3xl mx-auto bg-white p-10 rounded-3xl shadow-2xl">
            <h2 class="text-2xl font-black mb-8">Ajouter utilisateur</h2>

            <form class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <input type="text" placeholder="Nom" class="input">
                <input type="text" placeholder="Prénom" class="input">
                <input type="email" placeholder="Email" class="input">
                <input type="text" placeholder="CNI" class="input">
                <input type="password" placeholder="Mot de passe" class="input col-span-2">
                
                <div id="specialite-field" class="col-span-2">
                    <input type="text" placeholder="Spécialité" class="input w-full">
                </div>

                <button class="col-span-2 bg-gradient-to-r from-slate-900 to-blue-600 text-white py-4 rounded-2xl font-bold text-lg hover:scale-105 transition">
                    Ajouter
                </button>
            </form>
        </div>
    </div>
</main>

<style>
.input {
    background:#f1f5f9;
    padding:14px;
    border-radius:14px;
    outline:none;
}
.input:focus {
    box-shadow:0 0 0 2px #3b82f6;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    new Chart(document.getElementById('barChart'), {
        type:'bar',
        data:{
            labels:['Médecins','Secrétaires'],
            datasets:[{data:[10,5]}]
        }
    });

    new Chart(document.getElementById('pieChart'), {
        type:'doughnut',
        data:{
            labels:['Confirmés','Autres'],
            datasets:[{data:[20,10]}]
        }
    });
});

function switchTab(type){
    document.getElementById('view-stats').classList.add('hidden');
    document.getElementById('view-form').classList.add('hidden');

    if(type==='stats'){
        document.getElementById('view-stats').classList.remove('hidden');
    } else {
        document.getElementById('view-form').classList.remove('hidden');
    }
}
</script>

</body>
</html>
