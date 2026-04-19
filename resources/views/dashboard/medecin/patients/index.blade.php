@extends('dashboard.medecin.layout')

@section('title', 'Gestion des Patients')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white/80 backdrop-blur p-5 rounded-3xl shadow-lg border border-slate-100">

        <!-- SEARCH -->
        <form action="{{ route('medecin.rechercheCni') }}" method="POST" class="flex gap-2 w-full md:w-auto">
            @csrf
            <div class="relative w-full">
                <input type="text" name="cni" placeholder="Rechercher par CNI..."
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                
                <i class="fas fa-search absolute left-3 top-3.5 text-slate-400"></i>
            </div>

            <button type="submit"
                class="bg-blue-600 text-white px-5 py-3 rounded-xl font-bold shadow-md hover:bg-blue-700 hover:scale-105 transition">
                Rechercher
            </button>
        </form>

        <!-- ADD -->
        <button class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-3 rounded-xl font-bold shadow-md hover:scale-105 hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i> Nouveau Patient
        </button>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">

        <table class="w-full text-left">

            <!-- HEAD -->
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-8 py-4">Patient</th>
                    <th class="px-8 py-4">Sexe</th>
                    <th class="px-8 py-4">Téléphone</th>
                    <th class="px-8 py-4">Adresse</th>
                    <th class="px-8 py-4 text-right">Action</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody class="divide-y divide-slate-100">

                @forelse($patients as $patient)

                <tr class="group hover:bg-blue-50/50 transition duration-300">

                    <!-- PATIENT -->
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">

                            <!-- AVATAR -->
                            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 text-white flex items-center justify-center font-bold shadow">
                                {{ strtoupper(substr($patient->user->nom ?? 'P', 0, 1)) }}
                            </div>

                            <div>
                                <p class="font-bold text-slate-800">
                                    {{ $patient->user->nom ?? 'Inconnu' }} {{ $patient->user->prenom ?? '' }}
                                </p>
                                <p class="text-xs text-slate-400">Patient enregistré</p>
                            </div>

                        </div>
                    </td>

                    <!-- SEXE -->
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $patient->sexe == 'H' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                            {{ $patient->sexe ?? 'N/A' }}
                        </span>
                    </td>

                    <!-- TEL -->
                    <td class="px-8 py-5 text-slate-600 font-medium">
                        {{ $patient->telephone ?? 'Non renseigné' }}
                    </td>

                    <!-- ADR -->
                    <td class="px-8 py-5 text-slate-600 font-medium">
                        {{ $patient->adresse ?? 'Non renseignée' }}
                    </td>

                    <!-- ACTION -->
                    <td class="px-8 py-5 text-right">

                        <a href="{{ route('medecin.dossier', $patient->id) }}"
                           class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-xl font-bold shadow-sm hover:bg-blue-600 hover:text-white hover:scale-105 transition-all">
                            <i class="fas fa-folder-open text-sm"></i>
                            <span>Dossier</span>
                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="py-12 text-center text-slate-400">
                        Aucun patient trouvé.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="p-6 border-t border-slate-100">
            {{ $patients->links() }}
        </div>

    </div>

</div>

@endsection