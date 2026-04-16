<x-mail::message>
# Bienvenue sur School Way !

Bonjour **{{ $user->nom }} {{ $user->prenom }}**,

Votre compte a été créé avec succès. Vous pouvez désormais accéder à votre espace personnel pour suivre vos cours, vos absences et vos notes.

## Vos identifiants de connexion

Pour vous connecter, utilisez les informations suivantes :

<x-mail::panel>
**Email :** `{{ $user->email }}`

**Mot de passe :** `{{ $password }}`
</x-mail::panel>

<x-mail::button :url="route('login')">
Accéder à mon espace
</x-mail::button>


 **Conseil de sécurité :** Nous vous recommandons de modifier ce mot de passe dès votre première connexion depuis les paramètres de votre profil.

Si vous rencontrez des difficultés pour vous connecter, n'hésitez pas à contacter l'administration de l'établissement.

À très bientôt,

L'équipe **{{config('app.name')}}**
</x-mail::message>
