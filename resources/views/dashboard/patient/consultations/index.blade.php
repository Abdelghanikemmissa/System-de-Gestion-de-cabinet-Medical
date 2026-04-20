@extends('dashboard.patient.layouts.master')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Historique de mes consultations</h2>
    
    @if($consultations->isEmpty())
        <p class="text-gray-500">Aucune consultation trouvée.</p>
    @else
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Date</th>
                    <th class="p-2">Médecin</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consultations as $c)
                    <tr class="border-b">
                        <td class="p-2">{{ $c->date_consultation->format('d/m/Y') }}</td>
                        <td class="p-2">Dr. {{ $c->rendezvous->medecin->user->nom ?? 'Inconnu' }}</td>
                        <td class="p-2">
                            <a href="{{ route('patient.consultations.show', $c->id) }}" class="text-blue-600">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection