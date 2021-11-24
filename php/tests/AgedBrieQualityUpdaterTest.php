<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use GildedRose\QualityUpdater\AgedBrieQualityUpdater;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GildedRose\QualityUpdater\AgedBrieQualityUpdater
 */
class AgedBrieQualityUpdaterTest extends TestCase
{
    public function testAgedBrieTypeBeforeSellInDateUpdatesNormally(): void
    {
        $item = new Item('Aged Brie', 10, 10);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(11, $item->quality);
        $this->assertSame(9, $item->sell_in);
    }

    public function testAgedBrieTypeOnSellInDateUpdatesNormally(): void
    {
        $item = new Item('Aged Brie', 0, 10);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(12, $item->quality);
        $this->assertSame(-1, $item->sell_in);
    }

    public function testAgedBrieTypeAfterSellInDateUpdatesNormally(): void
    {
        $item = new Item('Aged Brie', -5, 10);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(12, $item->quality);
        $this->assertSame(-6, $item->sell_in);
    }

    public function testAgedBrieTypeBeforeSellInDateWithMaximumQuality(): void
    {
        $item = new Item('Aged Brie', 5, 50);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(4, $item->sell_in);
    }

    public function testAgedBrieTypeOnSellInDateNearMaximumQuality(): void
    {
        $item = new Item('Aged Brie', 0, 49);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(-1, $item->sell_in);
    }

    public function testAgedBrieTypeOnSellInDateWithMaximumQuality(): void
    {
        $item = new Item('Aged Brie', 0, 50);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(-1, $item->sell_in);
    }

    public function testAgedBrieTypeAfterSellInDateWithMaximumQuality(): void
    {
        $item = new Item('Aged Brie', -10, 50);
        $updater = new AgedBrieQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(-11, $item->sell_in);
    }
}
