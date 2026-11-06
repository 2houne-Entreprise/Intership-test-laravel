<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">Confirmer le mot de passe</h1>
    <p class="mt-1 text-sm text-gray-500">Cette zone est protégée. Confirmez votre mot de passe pour continuer.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="password" value="Mot de passe" />
            <x-icon-input icon="password" id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-2.5">Confirmer</x-primary-button>
    </form>
</x-guest-layout>
