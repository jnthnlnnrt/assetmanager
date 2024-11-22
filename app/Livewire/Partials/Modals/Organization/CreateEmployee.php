<?php

namespace App\Livewire\Partials\Modals\Organization;

use App\Models\Organization\Department;
use App\Models\Organization\Employee;
use App\Models\Organization\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateEmployee extends ModalComponent
{   
    public static function modalMaxWidth(): string {
        return 'lg';
    }

    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    public function create(){
        if(Employee::where('internal_id', $this->internal_id)->exists()){
            Toaster::error('Ya existe un departamento con el mismo ID, verifique.');
        } else{
            try{
                DB::beginTransaction();
                    Employee::create([
                        'internal_id' => strtoupper($this->internal_id),
                        'name' => $this->name,
                        'email' => $this->email,
                        'department_id' => $this->department,
                        'location_id' => $this->location,
                        'status' => 1,
                        'remarks' => $this->remarks,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                DB::commit();

                $this->dispatch('pg:eventRefresh-employees-table');
                $this->closeModal();
                Toaster::success('Registro insertado correctamente!'); 
            } catch(\Throwable $e){ 
                DB::rollBack();
                Toaster::error('Hubo un error al insertar el registro.' . $e->getMessage()); 
            }
        }
    }

    public function cancel(){
        $this->closeModal();
    }

    //Properties
    public $departments, $locations;

    public $internal_id, $name, $email, $department = '', $location = '', $remarks;

    public function mount(){
        $this->departments = Department::orderBy('name', 'asc')->get();
        $this->locations = Location::whereIn('type', ['U','B'])->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Agregar colaborador
                    </h3>
                </div>
                <!-- Modal body -->
                <form wire:submit="create">
                    <div class="grid gap-4 mb-4 sm:grid-cols-4">
                        <div>
                            <x-forms.label for="id">ID</x-forms.label>
                            <x-forms.input type="text" id="id" name="id" placeholder="ID" required="" wire:model="internal_id" maxlength="6" class="uppercase"/>
                        </div>
                        <div class="sm:col-span-3">
                            <x-forms.label for="name">Nombre</x-forms.label>
                            <x-forms.input type="text" id="name" name="name" placeholder="Nombre del colaborador" required="" wire:model="name"/>
                        </div>
                        <div class="sm:col-span-3">
                            <x-forms.label for="name">Correo electronico</x-forms.label>
                            <x-forms.input type="email" id="email" name="email" placeholder="Correo electronico" wire:model="email"/>
                        </div>
                        <div class="sm:col-span-2">
                            <x-forms.label for="id">Departamento</x-forms.label>
                            <x-forms.select wire:model="department" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">
                                        {{$department->name}}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="sm:col-span-2">
                            <x-forms.label for="id">Ubicacion</x-forms.label>
                            <x-forms.select wire:model="location" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($locations as $location)
                                    <option value="{{$location->id}}">
                                        {{$location->name}}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="sm:col-span-4">
                            <x-forms.label for="name">Comentarios</x-forms.label>
                            <x-forms.textarea wire:model="remarks"></x-forms.textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-2">
                        <x-buttons.default type="submit">
                            Guardar
                        </x-buttons.default>
                        <x-buttons.red type="button" wire:click="cancel">Cancelar</x-buttons.red>
                    </div>
                </form>
            </div>
        </div>
        HTML;
    }
}
