<?php

namespace App\Livewire\Partials\Modals\Organization;

use App\Models\Organization\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateDepartment extends ModalComponent
{
    public static function modalMaxWidth(): string {
        return 'md';
    }

    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    //Properties
    public $internal_id, $name, $remarks;

    public function create(){
        if(Department::where('internal_id', $this->internal_id)->exists()){
            Toaster::error('Ya existe un departamento con el mismo ID, verifique.');
        } else{
            try{
                DB::beginTransaction();
                    Department::create([
                        'internal_id' => strtoupper($this->internal_id),
                        'name' => $this->name,
                        'remarks' => $this->remarks,
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                DB::commit();

                $this->dispatch('pg:eventRefresh-departments-table');
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

    public function render()
    {
        return <<<'HTML'
        <div>
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Agregar departamento
                    </h3>
                </div>
                <!-- Modal body -->
                <form wire:submit="create">
                    <div class="grid gap-4 mb-4 sm:grid-cols-3">
                        <div>
                            <x-forms.label for="id">ID</x-forms.label>
                            <x-forms.input type="text" id="id" name="id" placeholder="ID" required="" wire:model="internal_id" maxlength="6" class="uppercase"/>
                        </div>
                        <div class="sm:col-span-2">
                            <x-forms.label for="name">Departamento</x-forms.label>
                            <x-forms.input type="text" id="name" name="name" placeholder="Nombre del departamento" required="" wire:model="name"/>
                        </div>
                        <div class="sm:col-span-3">
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
