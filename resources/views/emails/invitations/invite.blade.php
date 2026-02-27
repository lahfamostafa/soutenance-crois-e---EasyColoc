@component('mail::message')
# Invitation à rejoindre une colocation

Bonjour,

Vous avez été invité(e) à rejoindre la colocation **{{ $invitation->colocation->name }}**.

- Envoyée par : **{{ $invitation->sender->name }}**
- Email invité : **{{ $invitation->invited_email }}**

@component('mail::button', ['url' => $acceptUrl])
Voir l’invitation
@endcomponent

Si vous n’êtes pas concerné(e), vous pouvez ignorer cet email.

Merci,<br>
{{ config('app.name') }}
@endcomponent