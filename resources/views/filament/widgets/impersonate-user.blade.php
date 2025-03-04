<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament::card >
            @if (session('error'))
                <div class="text-red">{{ session('error') }}</div>
            @endif
            @if(auth()->user()->isSuperAdmin() or $this->original_user->isSuperAdmin())
                <form wire:submit.prevent="switchUser">
                    {{ $this->form }}
                    <button type="submit" class="bg-zinc-100 border font-semibold text-zinc-900 text-sm px-4 duration-200 py-2.5 transition-all ho mt-3">Switch User</button>
                </form>
            @endif

            @if (session()->has('original_user'))
                    <br><hr><br>
                <button wire:click="leaveImpersonation" class="bg-zinc-100 border font-semibold text-zinc-900 text-sm px-4 duration-200 py-2.5 transition-all ho mt-3">Return to Admin</button>
            @endif
        </x-filament::card>

    </x-filament::section>
</x-filament-widgets::widget>
