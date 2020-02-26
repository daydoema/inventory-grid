<?php
namespace Daydoema\InventoryGrid\Tests;

use Daydoema\InventoryGrid\Grid;
use PHPUnit\Framework\TestCase;

class GridTest extends TestCase {
    public function testGridConstructWithPropertySize()
    {
        $grid = new Grid(15,8);
        $gridSize = $grid->getSize();

        $this->assertIsArray($gridSize);
        $this->assertCount(2, $gridSize);
        $this->assertSame([15,8], $gridSize);
    }
}