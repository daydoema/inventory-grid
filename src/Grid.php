<?php
namespace Daydoema\InventoryGrid;

class Grid implements GridInterface {

    /**
     * @var array
     */
    private $matrix;
    /**
     * @var int
     */
    private $rows;
    /**
     * @var int
     */
    private $cols;

    public function __construct(int $cols, int $rows)
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->fillMatrix();
    }

    public function getSize(): array
    {
        return [$this->cols, $this->rows];
    }

    public function placeItem(int $width, int $height, int $x1, int $y1): void
    {
        $x2 = $x1 + $width - 1;
        $y2 = $y1 + $height -1;

        if (!$this->isAreaAvailable($x1, $y1, $x2, $y2)) {
            throw new \Exception('Some slots on area is already busy');
        }

        $this->takeArea($x1, $y1, $x2, $y2);
    }

    private function takeArea(int $x1, int $y1, int $x2, int $y2): void
    {
        $ranges = $this->getCoordinatesRanges($x1, $y1, $x2, $y2);

        foreach ($ranges['x'] as $x) {
            foreach ($ranges['y'] as $y) {
                $this->takeSlot($x, $y);
            }
        }
    }

    public function isAreaAvailable($x1, $y1, $x2, $y2): bool
    {
        $ranges = $this->getCoordinatesRanges($x1, $y1, $x2, $y2);

        foreach ($ranges['x'] as $x) {
            foreach ($ranges['y'] as $y) {
                if (!$this->isSlotAvailable($x, $y)) {
                    return false;
                }
            }
        }
        return true;
    }

    public function isSlotAvailable(int $x, int $y): bool
    {
        return $this->matrix[$x][$y] === false;
    }

    private function takeSlot(int $x, int $y)
    {
        $this->matrix[$x][$y] = true;
    }

    private function getCoordinatesRanges(int $x1, int $y1, int $x2, int $y2): array
    {
        return [
            'x' => range($x1, $x2),
            'y' => range($y1, $y2)
        ];
    }

    private function fillMatrix()
    {
        $this->matrix = array_fill(
            1,
            $this->cols,
            array_fill(
                1,
                $this->rows,
                false
            )
        );
    }

    public function getDebugScheme(): string
    {
        $ranges = $this->getCoordinatesRanges(1, 1, $this->cols, $this->rows);

        $output = PHP_EOL;
        foreach ($ranges['y'] as $y) {
            foreach ($ranges['x'] as $x) {
                $output .= $this->isSlotAvailable($x, $y) ? GridInterface::DEBUG_EMPTY_SLOT : GridInterface::DEBUG_BUSY_SLOT;
                if ($x === $this->cols) {
                    $output .= PHP_EOL;
                }
            }
        }
        return $output;
    }

    public function printDebugScheme(): void
    {
        echo $this->getDebugScheme();
    }
}