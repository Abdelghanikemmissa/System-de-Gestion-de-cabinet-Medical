<div class="relative pl-8 pb-10 border-l-2 border-slate-100 last:pb-0">
    <div class="absolute -left-[9px] top-0 w-4 h-4 bg-white border-4 border-blue-600 rounded-full"></div>
    <div class="bg-slate-50 p-6 rounded-3xl">
        <div class="flex justify-between items-start mb-4">
            <div>
                <span class="text-blue-600 font-black text-sm">{{ $consultation->created_at->format('d M Y') }}</span>
                <h4 class="text-lg font-black text-slate-800 mt-1">{{ $consultation->motif ?? 'Consultation sans motif' }}</h4>
            </div>
            <span class="bg-white px-3 py-1 rounded-lg text-[10px] font-black uppercase shadow-sm">ID: #{{ $consultation->id }}</span>
        </div>
        <p class="text-slate-500 text-sm mb-4">{{ Str::limit($consultation->compte_rendu, 150) }}</p>
        
        @include('dashboard.medecin.patients._ordonnance_actions', ['consultation' => $consultation])
    </div>
</div>