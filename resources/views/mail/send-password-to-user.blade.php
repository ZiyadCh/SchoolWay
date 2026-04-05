<x-mail::message>
Bienvenue sur SchoolWay. Voici vos identifiants pour vous connecter à votre espace :

- **Email :** {{ $user->email }}
- **Mot de passe :** {{ $password }}

<x-mail::button :url="config('app.name').'/login'">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
