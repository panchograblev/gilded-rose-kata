<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use GildedRose\QualityUpdater\BackstagePassQualityUpdater;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GildedRose\QualityUpdater\BackstagePassQualityUpdater
 */
class BackstagePassQualityUpdaterTest extends TestCase
{
    public function testBackstagePassBeforeSellOnDateUpdatesNormally(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 10, 10);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(12, $item->quality);
        $this->assertSame(9, $item->sell_in);
    }

    public function testBackstagePassMoreThanTenDaysBeforeSellOnDateUpdatesNormally(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 11, 10);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(11, $item->quality);
        $this->assertSame(10, $item->sell_in);
    }

    public function testBackstagePassUpdatesByThreeWithFiveDaysLeftToSell(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 5, 10);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(13, $item->quality);
        $this->assertSame(4, $item->sell_in);
    }

    public function testBackstagePassDropsToZeroAfterSellInDate(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(0, $item->quality);
        $this->assertSame(-1, $item->sell_in);
    }

    public function testBackstagePassCloseToSellInDateWithMaxQuality(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 10, 50);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(9, $item->sell_in);
    }

    public function testBackstagePassVeryCloseToSellInDateWithMaxQuality(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 5, 50);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(50, $item->quality);
        $this->assertSame(4, $item->sell_in);
    }

    public function testBackstagePassQualityZeroAfterSellDate(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', -5, 50);
        $updater = new BackstagePassQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(0, $item->quality);
        $this->assertSame(-6, $item->sell_in);
    }
}
