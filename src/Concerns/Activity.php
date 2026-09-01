<?php

declare(strict_types=1);

namespace Thettler\FilamentActivityViewer\Concerns;

use BackedEnum;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use Spatie\Activitylog\Contracts\Activity as ActivityContract;

interface Activity
{
    public ActivityContract $activity {
        get;
        set;
    }

    public function formatAttributeName(string $name, mixed $value): string;

    /*
     * @return (ValueCast|class-string<ValueCast>)[]
     */
    public function getCasts(): array;

    public function formatAttributeValue(mixed $value, string $name): string | Htmlable | View | null | int | float | bool | array;

    public function getIcon(): string | null | BackedEnum;

    public function getSecondaryIcon(): string | null | BackedEnum;

    public function getColor(): string | array | Color | null;

    public function getActions(): array;

    public function getTags(): array;

    /**
     * @return string|Htmlable|View|array<string|Htmlable|View|null>|null
     */
    public function title(): string | null | Htmlable | View | array;

    public function description(): string | null | Htmlable | View;

    public function content(): string | null | Htmlable | View;

    public function meta(): string | null | Htmlable | View;

    public function created_at(): string;

    public function created_at_tooltip(): ?string;

    public function causerName(): string | Htmlable;

    public function causerUrl(): ?string;

    public function causerLinkTag(): null | string | Htmlable;

    public function subject(): ?Model;

    public function subjectType(): string | Htmlable;

    public function subjectName(): string | Htmlable;

    public function subjectIcon(): string | Htmlable | BackedEnum | null;

    public function subjectUrl(): ?string;

    public function subjectLinkTag(): null | string | Htmlable;
}
