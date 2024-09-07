<?php

namespace App\Livewire\Partials\Organization;

use App\Models\Organization\Department;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CreateDepartmentModal extends ModalComponent
{
    public $internal_id, $name;

    public function save(){
        try {
            $department = Department::create([
                'internal_id' => $this->internal_id,
                'name' => $this->name,
                'created_by' => 1,
                'updated_by' => 1
            ]);
    
            $this->dispatch('pg:eventRefresh-DepartmentsTable');
    
            $this->closeModal();
        } catch (\Throwable $e) {
            dd($e);
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
            <form wire:submit='save'>
                <div class="grid gap-4 mb-4 md:grid-cols-3">
                    <div>
                        <x-forms.label for="internal_id">ID:</x-forms.label>
                        <x-forms.input type="text" id="internal_id" name="internal_id" placeholder="ID" required wire:model='internal_id'/>
                    </div>
                    <div class="md:col-span-2">
                        <x-forms.label for="name">Departamento:</x-forms.label>
                        <x-forms.input type="text" id="name" name="name" placeholder="Nombre del departamento" required wire:model='name'/>
                    </div>
                </div>
                <div class="flex items-center justify-end pt-2 space-x-2">
                    <x-buttons.primary type="submit">
                        Guardar
                    </x-buttons.primary>
                    <x-buttons.danger type="button" wire:click="cancel">
                        Cancelar
                    </x-buttons.danger>
                </div>
            </form>
        </div>
        </div>
        HTML;
    }
}
