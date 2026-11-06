<div>
    <x-input-label for="title" :value="__('Titre')" />
    <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title', $task?->title)" />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="status" :value="__('Statut')" />
        <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @foreach (App\Enums\TaskStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(old('status', $task?->status->value) === $status->value)>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="deadline" :value="__('Échéance')" />
        <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full" :value="old('deadline', $task?->deadline?->format('Y-m-d'))" />
        <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
    </div>
</div>
