<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">Connexion</h1>
    <p class="mt-1 text-sm text-gray-500">Accédez à vos projets.</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Adresse e-mail" />
            <x-icon-input icon="email" id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Mot de passe" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Mot de passe oublié ?</a>
                @endif
            </div>
            <x-icon-input icon="password" id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="text-sm text-gray-600">Se souvenir de moi</span>
        </label>

        <x-primary-button class="w-full justify-center py-2.5">Se connecter</x-primary-button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-700">Créer un compte</a>
    </p>
</x-guest-layout>
