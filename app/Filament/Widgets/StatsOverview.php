<?php

namespace App\Filament\Widgets;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Projects', Project::count()),
            Stat::make('Skills', Skill::count()),
            Stat::make('Experiences', Experience::count()),
        ];
    }
}
