<h1>{{ $colocation->name }}</h1>
<h2>{{ $colocation->status }}</h2>

<hr>

<h3>Membres :</h3>

@foreach($colocation->memberShips as $membership)
    @if($membership->left_at === null)
        <div>
            {{ $membership->user->name }} ({{ $membership->role }})
        </div>
    @endif
@endforeach

<hr>
@if (auth()->id() === $colocation->owner_id)

    <form method="POST" action="{{ route("colocations.destroy",$colocation) }}">
        @csrf
        @method('DELETE')
        <button type="submit">Desactiver la colocation</button>
    </form>

    <h3>Envoyer une invitation</h3>

    <form method="POST" action="{{ route('invitations.store', $colocation) }}">
        @csrf
        <input type="email" name="invited_email" placeholder="Email du membre">
        <button type="submit">Inviter</button>
    </form>

    <hr>

    <h3>Invitations en attente</h3>

    @foreach($colocation->invitations as $inv)
        @if($inv->status === 'pending')
            <div>
                {{ $inv->invited_email }} (pending)
            </div>
        @endif
    @endforeach
@endif

<a href="{{ route('colocations.index') }}">Retour</a>