<?php

declare(strict_types=1);

namespace Lavertia\Panels;

use Illuminate\Support\ServiceProvider;

final class PanelsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../resources/js/lavertia' => resource_path('js/lavertia'),
            __DIR__.'/../resources/js/Pages/Lavertia' => resource_path('js/Pages/Lavertia'),
        ], 'lavertia-vue');
    }
}
