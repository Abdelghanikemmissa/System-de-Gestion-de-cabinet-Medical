<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPlus - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hidden { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 flex min-h-screen">

    <aside class="w-64 bg-white border-r border-slate-100 flex flex-col p-6 sticky top-0 h-screen">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold">M+</div>
            <span class="text-xl font-bold text-slate-800">MediPlus</span>
        </div>
        <nav class="flex flex-col gap-2 flex-grow">
            <button onclick="switchTab('stats')" id="nav-stats" class="nav-link flex items-center gap-3 p-3 rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-100 font-semibold transition">
                <span>📊</span> Dashboard
            </button>
            <button onclick="switchTab('medecin')" id="nav-medecin" class="nav-link flex items-center gap-3 p-3 rounded-xl text-slate-500 hover:bg-slate-50 font-semibold transition text-left">
                <span>👨‍⚕️</span> Ajouter Médecins
            </button>
            <button onclick="switchTab('secretaire')" id="nav-secretaire" class="nav-link flex items-center gap-3 p-3 rounded-xl text-slate-500 hover:bg-slate-50 font-semibold transition text-left">
                <span>📝</span> Ajouter Secrétaire
            </button>
        </nav>
    </aside>

    <main class="flex-grow p-8">
        <h1 class="text-3xl font-black mb-8 text-slate-800" id="main-title">Statistiques Générales</h1>

        <div id="view-stats" class="admin-view space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold mb-6 text-slate-700">Répartition du Personnel</h3>
                    <canvas id="barChart" height="200"></canvas>
                </div>
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-bold mb-6 text-slate-700">État des Rendez-vous</h3>
                    <div class="max-w-[300px] mx-auto">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div id="view-form" class="admin-view hidden">
            <div class="max-w-4xl bg-white p-10 rounded-[3rem] shadow-xl border border-white">
                <h2 id="form-subtitle" class="text-xl font-bold mb-8 text-slate-800">Ajouter un nouveau membre</h2>
                
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.staff.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @csrf
                    <input type="hidden" name="role" id="input-role" value="medecin">

                    <input type="text" name="nom" placeholder="Nom" class="bg-slate-50 p-4 rounded-2xl border-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="text" name="prenom" placeholder="Prénom" class="bg-slate-50 p-4 rounded-2xl border-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="email" name="email" placeholder="Email professionnel" class="bg-slate-50 p-4 rounded-2xl border-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="text" name="cni" placeholder="CNI" class="bg-slate-50 p-4 rounded-2xl border-none focus:ring-2 focus:ring-blue-500" required>
                    <input type="password" name="password" placeholder="Mot de passe temporaire" class="bg-slate-50 p-4 rounded-2xl border-none focus:ring-2 focus:ring-blue-500 col-span-2" required>
                    
                    <div id="specialite-field" class="col-span-2">
                        <input type="text" name="specialite" id="input-specialite" placeholder="Spécialité Médicale" class="w-full bg-slate-50 p-4 rounded-2xl border-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <button type="submit" class="mt-4 col-span-2 bg-slate-900 text-white py-5 rounded-2xl font-black text-lg hover:bg-blue-600 transition-all">
                        Confirmer l'ajout
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Graphiques Chart.js
        document.addEventListener('DOMContentLoaded', function() {
            const ctxBar = document.getElementById('barChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Médecins', 'Secrétaires'],
                    datasets: [{
                        data: [{{ $stats['total_medecins'] }}, {{ $stats['total_secretaires'] }}],
                        backgroundColor: ['#3b82f6', '#10b981'],
                        borderRadius: 12
                    }]
                },
                options: { plugins: { legend: { display: false } } }
            });

            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Confirmés', 'Autres'],
                    datasets: [{
                        data: [{{ $stats['rdv_confirmes'] }}, {{ $stats['total_rdv'] - $stats['rdv_confirmes'] }}],
                        backgroundColor: ['#f59e0b', '#e2e8f0']
                    }]
                }
            });
        });

        // Fonction de navigation
        function switchTab(type) {
            const viewStats = document.getElementById('view-stats');
            const viewForm = document.getElementById('view-form');
            const navLinks = document.querySelectorAll('.nav-link');
            const mainTitle = document.getElementById('main-title');
            const roleInput = document.getElementById('input-role');
            const specField = document.getElementById('specialite-field');
            const specInput = document.getElementById('input-specialite');

            viewStats.classList.add('hidden');
            viewForm.classList.add('hidden');
            navLinks.forEach(l => {
                l.classList.remove('bg-blue-600', 'text-white', 'shadow-lg', 'shadow-blue-100');
                l.classList.add('text-slate-500', 'hover:bg-slate-50');
            });

            if (type === 'stats') {
                viewStats.classList.remove('hidden');
                document.getElementById('nav-stats').classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                mainTitle.innerText = "Statistiques Générales";
            } else {
                viewForm.classList.remove('hidden');
                roleInput.value = type;

                if (type === 'medecin') {
                    document.getElementById('nav-medecin').classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                    mainTitle.innerText = "Gestion des Médecins";
                    specField.classList.remove('hidden');
                    specInput.required = true;
                } else if (type === 'secretaire') {
                    document.getElementById('nav-secretaire').classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                    mainTitle.innerText = "Gestion des Secrétaires";
                    specField.classList.add('hidden');
                    specInput.required = false;
                    specInput.value = '';
                }
            }
        }
    </script>
</body>
</html>