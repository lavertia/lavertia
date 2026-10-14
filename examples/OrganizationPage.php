<?php

declare(strict_types=1);

namespace App\Lavertia;

use Lavertia\Panels\Components\Action;
use Lavertia\Panels\Components\Infolist;
use Lavertia\Panels\Components\Table;
use Lavertia\Panels\Components\TextColumn;
use Lavertia\Panels\Components\TextEntry;
use Lavertia\Panels\Pages\Page;
use Lavertia\Support\Components\Card;
use Lavertia\Support\Components\Text;
use Lavertia\Support\Contracts\Component;

final class OrganizationPage extends Page
{
    /** @return list<Component> */
    protected function components(): array
    {
        return [
            Text::make('Organization'),
            Card::make([
                Infolist::make('organization')->components([
                    TextEntry::make('name')->label('Company')->value('Fenix Software'),
                ]),
                Action::make('home')->label('Home')->url('/'),
            ])->key('organization-details'),
            Card::make([
                Table::make('users')->columns([
                    TextColumn::make('name')->label('Name'),
                    TextColumn::make('email')->label('Email'),
                ])->rows([
                    ['name' => 'Sara', 'email' => 'sara@example.com'],
                    ['name' => 'Ahmad', 'email' => 'ahmad@example.com'],
                ]),
            ])->key('users-card'),
        ];
    }
}

// Application route (define in routes/web.php under appropriate auth middleware):
// Route::middleware(['auth'])->get('/admin/organization', OrganizationPage::class);
