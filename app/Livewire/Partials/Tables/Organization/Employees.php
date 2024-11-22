<?php

namespace App\Livewire\Partials\Tables\Organization;

use App\Models\Organization\Employee;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class Employees extends PowerGridComponent
{
    public string $tableName = 'employees-table';

    use WithExport; 

    public string $sortField = 'internal_id'; 

    public string $sortDirection = 'asc';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable(fileName: 'my-export-file') 
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Employee::query()
            ->with('department')
            ->with('location');
    }

    public function relationSearch(): array
    {
        return [
            'department' => [
                'name',
            ],

            'location' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('internal_id_link', function($employee){
                return sprintf(
                    '<a href="/organization/employees/edit/%s" wire:navigate class="text-blue-600 font-medium">' . $employee->internal_id . '</a>', urlencode(e($employee->id)), e($employee->id)
                );
            })
            ->add('name')
            ->add('department', fn ($employee) => e($employee->department->name))
            ->add('location', fn ($employee) => e($employee->location->name))
            ->add('status', function ($employee){
                if($employee->status === 0){
                    return 'Inactivo';
                } elseif($employee->status === 1){
                    return 'Activo';
                }
            });;
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'internal_id_link', 'internal_id')
                ->searchable()
                ->sortable(),

            Column::make('Nombre', 'name')
                ->searchable()
                ->sortable(),
            
            Column::make('Correo electronico', 'email')
                ->searchable()
                ->sortable(),
            
            Column::make('Departamento', 'department', 'department_id')
                ->searchable()
                ->sortable(),

            Column::make('Ubicacion', 'location', 'location_id')->hidden(isHidden: true, isForceHidden: false)
                ->searchable()
                ->sortable(),
            
            Column::make('Estatus', 'status')
                ->searchable()
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    /*
    public function actionRules(Employee $row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
