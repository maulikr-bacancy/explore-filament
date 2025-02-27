{{--<x-filament::page>--}}
    <div class="p-6  rounded-lg shadow-lg mt-3">
        @if (session('error'))
            <div class="mb-4 p-3 text-red-700 bg-red-100 border border-red-400 rounded-md">
                {{ session('error') }}
            </div>
        @endif

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Select a Practice</h2>

        <!-- Search Form -->
        {{ $this->form }} <br>

        <div class="mt-4 space-y-2">
            @foreach ($this->practices as $practice)
                <div class="flex items-center justify-between p-4 border rounded-lg shadow-sm">
                    <span class="text-gray-700 text-lg font-medium">{{ $practice->ID.') '.$practice->Name }}</span>
                    <a href="#" wire:click.prevent="switchPractice({{ $practice->ID }})"
                       class="px-4 py-2  text-black text-sm font-medium rounded-md shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 transition-all">
                        Switch
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-6 ">
            {{ $this->practices->links() }}
        </div>
    </div>
{{--</x-filament::page>--}}
