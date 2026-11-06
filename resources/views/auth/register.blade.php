<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">Créer un compte</h1>
    <p class="mt-1 text-sm text-gray-500">Commencez à organiser vos projets.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nom" />
            <x-icon-input icon="user" id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-icon-input icon="email" id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-icon-input icon="password" id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmer le mot de passe" />
            <x-icon-input icon="password" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-2.5">Créer mon compte</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Déjà inscrit ?
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Se connecter</a>
    </p>
</x-guest-layout>
