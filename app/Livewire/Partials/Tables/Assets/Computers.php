<?php

namespace App\Livewire\Partials\Tables\Assets;

use App\Models\Asset;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class Computers extends PowerGridComponent
{
    public string $tableName = 'computers-table';

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
        return Asset::query()
            ->with(['manufacturer', 'subtype', 'status', 'employee', 'location']);
    }

    public function relationSearch(): array
    {
        return [
            'employee' => [
                'name',
            ],
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('asset_tag')
            ->add('at_link', function($computer){
                return sprintf(
                    '<a href="/assets/computers/edit/%s" wire:navigate class="text-blue-600">' . $computer->asset_tag . '</a>', urlencode(e($computer->id)), e($computer->id)
                );
            })
            ->add('manufacturer', fn ($computer) => e($computer->manufacturer->name))
            ->add('model')
            ->add('serial')
            ->add('subtype', fn ($computer) => e($computer->subtype->name))       
            ->add('status', fn ($computer) => e($computer->status->name))      
            ->add('employee', fn ($computer) => e($computer->employee->name))     
            ->add('department', fn ($computer) => e($computer->employee->department->name))     
            ->add('location', fn ($computer) => e($computer->location->name))  
            ->add('require_maintenance')
            ->add('frequency_id')
            ->add('last_maintenance_formatted', fn (Asset $model) => Carbon::parse($model->last_maintenance)->format('d/m/Y'))
            ->add('frequency', function($computer){
                return $computer->frequency->lower_limit . " a " . $computer->frequency->upper_limit . " meses";
            })
            ->add('sm', function($computer){
                $lm = new DateTime($computer->last_maintenance);
                $today = new DateTime(date("Y-m-d"));

                $interval = $today->diff($lm);

                $months = ($interval->y * 12) + $interval->m;

                return $months . " meses";
            })
            ->add('score', function($computer){
                $lm = new DateTime($computer->last_maintenance);
                $today = new DateTime(date("Y-m-d"));

                $interval = $today->diff($lm);

                $months = ($interval->y * 12) + $interval->m;

                if (($months >= 0) && ($months <= $computer->frequency->lower_limit)){
                    return Blade::render('<x-badges.success>En tiempo</x-badges.success>');
                } elseif(($months >= $computer->frequency->lower_limit) && ($months <= $computer->frequency->upper_limit)) {
                    return Blade::render('<x-badges.warning>Programar</x-badges.warning>');
                } elseif($months > $computer->frequency->upper_limit){
                    return Blade::render('<x-badges.alert>Fuera de tiempo</x-badges.alert>');
                }
            })
            ->add('score_export', function($computer){
                $lm = new DateTime($computer->last_maintenance);
                $today = new DateTime(date("Y-m-d"));

                $interval = $today->diff($lm);

                $months = ($interval->y * 12) + $interval->m;

                if (($months >= 0) && ($months <= $computer->frequency->lower_limit)){
                    return 'En tiempo';
                } elseif(($months >= $computer->frequency->lower_limit) && ($months <= $computer->frequency->upper_limit)) {
                    return 'Programar';
                } elseif($months > $computer->frequency->upper_limit){
                    return 'Fuera de tiempo';
                }
            })
            ->add('carry_authorization', function ($computer){
                if($computer->carry_authorization === 0){
                    return Blade::render('<x-badges.alert>No autorizado</x-badges.alert>');
                } elseif($computer->carry_authorization === 1){
                    return Blade::render('<x-badges.success>Autorizado</x-badges.success>');
                } elseif($computer->carry_authorization === 2){
                    return Blade::render('<x-badges.warning>Requiere autorizacion</x-badges.warning>');
                } 
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Asset Tag', 'at_link', 'asset_tag')
                ->sortable()
                ->searchable(),

            Column::make('Marca', 'manufacturer', 'manufacturer_id')
                ->sortable(),

            Column::make('Modelo', 'model')
                ->sortable()
                ->searchable(),

            Column::make('Serie', 'serial')
                ->sortable()
                ->searchable(),
            
            Column::make('Tipo', 'subtype'),

            Column::make('Estatus', 'status'),

            Column::make('Usuario actual', 'employee', 'employee_id')
                ->searchable(),

            Column::make('Departamento', 'department'),

            Column::make('Ubicacion', 'location'),

            Column::make('UM', 'last_maintenance_formatted', 'last_maintenance')
                ->hidden(isHidden: true, isForceHidden: false)
                ->sortable(),

            Column::make('FQ', 'frequency')->hidden(isHidden: true, isForceHidden: false),

            Column::make('SM', 'sm')->hidden(isHidden: true, isForceHidden: false),

            Column::make('Mantenimiento', 'score')
                ->visibleInExport(false),

            Column::make('Mantenimiento', 'score_export')
                ->visibleInExport(true)
                ->hidden(true),

            Column::make('Autorizacion de salida', 'carry_authorization')
                ->visibleInExport(false)
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
