<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">{{ __('Mot de passe oublié') }}</h1>
    <p class="mt-1 text-sm text-gray-500">{{ __('Entrez votre adresse e-mail, nous vous enverrons un lien pour en choisir un nouveau.') }}</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-icon-input icon="email" id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-2.5">{{ __('Envoyer le lien') }}</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-700">{{ __('Retour à la connexion') }}</a>
    </p>
</x-guest-layout>
