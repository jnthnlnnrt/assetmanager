<?php

namespace App\Livewire\Partials\Tables\Organization;

use App\Models\Organization\Department;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable; 

final class Departments extends PowerGridComponent
{
    public string $tableName = 'departments-table';

    use WithExport; 

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
        return Department::query()->orderBy('internal_id');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('internal_id')
            ->add('internal_id_button', fn ($department) => Blade::render('<button class="text-blue-600 font-medium" wire:click="$dispatch(' . "'openModal'" . ', {component:' . "'partials.modals.organization.EditDepartment'" . ', arguments: {id: {{' . $department->id . '}} }})">' . $department->internal_id . '</button>'))
            ->add('name')
            ->add('employees', fn ($department) => e($department->employees->count()));
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'internal_id_button', 'internal_id')
                ->sortable()
                ->searchable()
                ->visibleInExport(visible: false),

            Column::make('ID', 'internal_id')
                ->hidden()
                ->visibleInExport(visible: true),

            Column::make('Departamento', 'name')
                ->sortable()
                ->searchable(),

            Column::make('<i class="fa-solid fa-users"></i>', 'employees'),

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
    public function actionRules($row): array
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
