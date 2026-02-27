<h1>Mes colocations</h1>

@if(session('error'))
    <div style="color:red;">
        {{ session('error') }}
    </div>
@endif

<a href="{{ route('colocations.create') }}">Créer une colocation</a>

<hr>

@if($colocations->isEmpty())
    <p>Aucune colocation trouvée.</p>
@else
    @foreach($colocations as $colocation)
        <div>
            <a href="{{ route('colocations.show', $colocation) }}">
                {{ $colocation->name }}
            </a>
        </div>
    @endforeach
@endif