<div class="space-y-4">
    <!-- Page header -->
    <header class="font-semibold text-xl md:text-2xl pt-1 pb-3 border-b border-gray-300">
        <div class="flex items-center justify-between">
            <div>
                Departamentos
            </div>
            <div>
                <x-buttons.primary wire:click="$dispatch('openModal', {component:'partials.organization.CreateDepartmentModal'})">Agregar</x-buttons.primary>
            </div>
        </div>
    </header>
    <div>
        <livewire:tables.organization.departments-table/>
    </div>
</div>