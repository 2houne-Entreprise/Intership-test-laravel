@use('App\TaskStatus')

<div>
    <x-input-label for="title" value="Titre" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $task?->title)" />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div>
    <x-input-label for="status" value="Statut" />
    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @foreach (TaskStatus::cases() as $status)
            <option value="{{ $status->value }}" @selected(old('status', $task?->status->value ?? TaskStatus::Pending->value) === $status->value)>
                {{ $status->label() }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('status')" class="mt-2" />
</div>

<div>
    <x-input-label for="deadline" value="Échéance" />
    <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full" :value="old('deadline', $task?->deadline?->format('Y-m-d'))" />
    <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
</div>

<div>
    <x-input-label for="attachment" value="Pièce jointe (optionnelle, 5 Mo max)" />
    <input id="attachment" name="attachment" type="file" class="mt-1 block w-full text-sm text-gray-700" />
    @if ($task?->attachment_url)
        <p class="mt-1 text-sm text-gray-600">
            Fichier actuel : <a href="{{ $task->attachment_url }}" class="text-indigo-600 hover:underline" download>télécharger</a>
            (envoyer un nouveau fichier le remplace)
        </p>
    @endif
    <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
</div>
