<h1>Invitation</h1>

<p>
Vous êtes invité à rejoindre la colocation :
<strong>{{ $invitation->colocation->name }}</strong>
</p>

<p>Envoyée par : {{ $invitation->sender->name }}</p>

@if($invitation->status !== 'pending')
    <p>Status : {{ $invitation->status }}</p>
@else

<form method="POST" action="{{ route('invitations.accept', $invitation->token) }}">
    @csrf
    <button type="submit">Accepter</button>
</form>

<form method="POST" action="{{ route('invitations.refuse', $invitation->token) }}">
    @csrf
    <button type="submit">Refuser</button>
</form>

@endif