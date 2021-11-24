<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use GildedRose\QualityUpdater\SulfurasQualityUpdater;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GildedRose\QualityUpdater\SulfurasQualityUpdater
 */
class SulfurasQualityUpdaterTest extends TestCase
{
    public function testSulfurasWithNormalQuantity(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 10, 10);
        $updater = new SulfurasQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(11, $item->quality);
        $this->assertSame(10, $item->sell_in);
    }

    public function testSulfurasWithMaximumQuantity(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 0, 50);
        $updater = new SulfurasQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(0, $item->sell_in);
    }
}
