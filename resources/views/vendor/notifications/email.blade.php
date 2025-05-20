@component('mail::message')
# Vérification de votre adresse email

Bonjour {{ $notifiable->Username }},

Merci de vous être inscrit sur notre plateforme. Pour activer votre compte, veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email.

@component('mail::button', ['url' => $actionUrl])
Vérifier mon email
@endcomponent

Si vous n'avez pas créé de compte, aucune action n'est requise.

Cordialement,<br>
{{ config('app.name') }}

@component('mail::subcopy')
Si vous avez des difficultés à cliquer sur le bouton "Vérifier mon email", copiez et collez l'URL ci-dessous
dans votre navigateur web : [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endcomponent 