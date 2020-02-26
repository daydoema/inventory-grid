<?php
namespace Daydoema\InventoryGrid;

interface GridInterface
{
    const DEBUG_EMPTY_SLOT = ' ░ ';
    const DEBUG_BUSY_SLOT = ' █ ';

    public function __construct(int $cols, int $rows);
    public function getSize(): array;
    public function placeItem(int $width, int $height, int $x2, int $y2): void;
    public function isSlotAvailable(int $x, int $y): bool;
    public function isAreaAvailable(int $x1, int $y1, int $x2, int $y2): bool;
    public function getDebugScheme(): string;
    public function printDebugScheme(): void;
}