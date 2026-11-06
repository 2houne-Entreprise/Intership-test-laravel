<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">Nouveau mot de passe</h1>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-icon-input icon="email" id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
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

        <x-primary-button class="w-full justify-center py-2.5">Enregistrer le mot de passe</x-primary-button>
    </form>
</x-guest-layout>
