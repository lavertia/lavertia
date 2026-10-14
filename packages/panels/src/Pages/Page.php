<?php

declare(strict_types=1);

namespace Lavertia\Panels\Pages;

use Inertia\Inertia;
use Inertia\Response;
use Lavertia\Support\Components\Column;
use Lavertia\Support\Contracts\Component;

abstract class Page
{
    /**
     * @return list<Component>
     */
    abstract protected function components(): array;

    /** @return array<string, mixed> */
    final public function tree(): array
    {
        return Column::make($this->components())->toArray();
    }

    final public function __invoke(): Response
    {
        return Inertia::render('Lavertia/PanelPage', [
            'lavertia' => ['tree' => $this->tree()],
        ]);
    }
}
