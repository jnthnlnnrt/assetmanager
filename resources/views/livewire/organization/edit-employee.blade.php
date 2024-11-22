<div class="space-y-3">
    <form class="space-y-3" wire:submit="update">
        <header class="pb-2 border-b border-gray-300 flex justify-between items-center">
            <div>
                <div>
                    <a href="{{ route('employees') }}" wire:navigate class="font-sm font-medium text-blue-600 dark:text-blue-500 hover:underline"><i class="fa-solid fa-arrow-left"></i> Regresar</a>
                </div>
                <div class="text-2xl font-semibold">
                    Editar colaborador
                </div>
            </div>
            <div class="space-x-1">
                <x-buttons.default type="submit">Guardar</x-buttons.default>
            </div>
        </header>
        <div class="grid sm:grid-cols-10 gap-4">
            <div class="sm:col-span-2">
                <x-forms.label for="id">ID</x-forms.label>
                <x-forms.input-white type="text" id="id" name="id" placeholder="ID" required="" wire:model="internal_id" maxlength="6" class="uppercase"/>
            </div>
            <div class="sm:col-span-5">
                <x-forms.label for="name">Nombre</x-forms.label>
                <x-forms.input-white type="text" id="name" name="name" placeholder="Nombre del colaborador" required="" wire:model="name"/>
            </div>
            <div class="sm:col-span-3">
                <x-forms.label for="name">Correo electronico</x-forms.label>
                <x-forms.input-white type="email" id="email" name="email" placeholder="Correo electronico" wire:model="email"/>
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="id">Departamento</x-forms.label>
                <x-forms.select-white wire:model="department" required>
                    <option value="" disabled>Seleccione...</option>
                    @foreach($departments as $department)
                        <option value="{{$department->id}}">
                            {{$department->name}}
                        </option>
                    @endforeach
                </x-forms.select-white>
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="id">Ubicacion</x-forms.label>
                <x-forms.select-white wire:model="location" required>
                    <option value="" disabled>Seleccione...</option>
                    @foreach($locations as $location)
                        <option value="{{$location->id}}">
                            {{$location->name}}
                        </option>
                    @endforeach
                </x-forms.select-white>
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="id">Estatus</x-forms.label>
                <x-forms.select-white wire:model="status" required>
                    <option value="" disabled>Seleccione...</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </x-forms.select-white>
            </div>
            <div class="sm:col-span-10">
                <x-forms.label for="name">Comentarios</x-forms.label>
                <x-forms.input-white type="text" id="remarks" name="remarks" placeholder="Comentarios" wire:model="remarks"/>
            </div>
        </div>
    </form>
</div>