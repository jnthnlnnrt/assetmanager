<div class="space-y-3">
    <header class="pb-2 border-b border-gray-300 flex justify-between items-center">
        <div class="text-2xl font-semibold">
            Equipos de computo
        </div>
        <div>
            <x-buttons.default type="button" onclick="Livewire.dispatch('openModal', { component: 'partials.modals.assets.CreateComputer' })">
                <i class="fa-solid fa-plus"></i>
                <span class="ml-1">Nuevo</span>
            </x-buttons.default>
        </div>
    </header>
    <div>
        <livewire:partials.tables.assets.computers/>
    </div>
</div>