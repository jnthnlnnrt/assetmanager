<?php

namespace App\Livewire\Partials\Tables;

use App\Models\AssetEvent;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Maintenances extends PowerGridComponent
{
    public string $asset;

    public string $tableName = 'maintenances-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage(perPage:5, perPageValues: [5, 10, 100, 500])
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return AssetEvent::query()
         ->with('type');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('event_tag')
            ->add('event_type_id')
            ->add('type', fn ($event) => e($event->type->name))  
            ->add('start_date_formatted', fn (AssetEvent $model) => Carbon::parse($model->start_date)->format('d/m/Y'))
            ->add('end_date_formatted', fn (AssetEvent $model) => Carbon::parse($model->end_date)->format('d/m/Y'))
            ->add('status')
            ->add('remarks');
    }

    public function columns(): array
    {
        return [
            Column::make('Event tag', 'event_tag')
                ->sortable()
                ->searchable(),
            Column::make('Event type ID', 'type'),
            Column::make('Start date', 'start_date_formatted', 'start_date')
                ->sortable(),

            Column::make('End date', 'end_date_formatted', 'end_date')
                ->sortable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),
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
