<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\Activity;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Filament\Resources\ContactMessages\ContactMessageResource;

class OverviewStats extends BaseWidget
{
    protected ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        return [
            $this->makeStat(__('dashboard.stats.total_news'), News::count(), 'primary', 'heroicon-m-newspaper', __('dashboard.stats.view_news'), route('filament.admin.resources.news.index')),
            $this->makeStat(__('dashboard.stats.total_activities'), Activity::count(), 'gray', 'heroicon-m-rectangle-stack', __('dashboard.stats.view_activities'), route('filament.admin.resources.activities.index')),
            $this->makeStat(__('dashboard.stats.total_events'), Event::count(), 'warning', 'heroicon-m-calendar-days', __('dashboard.stats.view_events'), route('filament.admin.resources.events.index')),
            $this->makeStat(__('dashboard.stats.total_users'), User::count(), 'success', 'heroicon-m-user-group', __('dashboard.stats.view_users'), route('filament.admin.resources.users.index')),
            $this->makeStat(__('dashboard.stats.visitors_messages'), ContactMessage::count(), 'danger', 'heroicon-m-envelope', __('dashboard.stats.view_messages'), ContactMessageResource::getUrl('index')),
        ];
    }

    protected function makeStat(string $label, int $count, string $color, string $icon, string $actionText, ?string $url = null): Stat
    {
        $stat = Stat::make($label, $count)
            ->color($color)
            ->description($actionText . ' »')
            ->descriptionIcon($icon)
            ->chart($this->getProportionalChart($count));

        return $url ? $stat->url($url) : $stat;
    }

    protected function getProportionalChart(int $count): array
    {
        if ($count === 0) return [0, 0, 0, 0, 0, 0, 0];

        return [
            (int)($count * 0.2), (int)($count * 0.5), (int)($count * 0.3),
            (int)($count * 0.8), (int)($count * 0.4), (int)($count * 0.9), (int)($count * 0.6),
        ];
    }

    public static function canView(): bool
    {
        return (bool) auth()->user()?->hasAnyRole(['admin', 'content']);
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
