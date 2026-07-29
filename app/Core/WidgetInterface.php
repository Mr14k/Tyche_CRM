<?php

declare(strict_types=1);

namespace App\Core;

interface WidgetInterface
{
    public function getKey(): string;
    public function getTitle(): string;
    public function getRequiredPermission(): ?string;
    public function render(): string;
}
