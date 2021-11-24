<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\Item;
use GildedRose\QualityUpdater\DefaultQualityUpdater;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GildedRose\QualityUpdater\DefaultQualityUpdater
 */
class DefaultQualityUpdaterTest extends TestCase
{
    public function testElixirBeforeSellInDateUpdatesNormally(): void
    {
        $item = new Item('Elixir of the Mongoose', 10, 10);
        $updater = new DefaultQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(9, $item->quality);
        $this->assertSame(9, $item->sell_in);
    }

    public function testDexterityVestBeforeSellInDateUpdatesNormally(): void
    {
        $item = new Item('+5 Dexterity Vest', 10, 10);
        $updater = new DefaultQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(9, $item->quality);
        $this->assertSame(9, $item->sell_in);
    }

    public function testDexterityVestOnSellInDateQualityDegradesTwiceAsFast(): void
    {
        $item = new Item('+5 Dexterity Vest', 0, 10);
        $updater = new DefaultQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(8, $item->quality);
        $this->assertSame(-1, $item->sell_in);
    }

    public function testDexterityVestAfterSellInDateQualityDegradesTwiceAsFast(): void
    {
        $item = new Item('+5 Dexterity Vest', -1, 10);
        $updater = new DefaultQualityUpdater();
        $updater->updateQuality($item);

        $this->assertSame(8, $item->quality);
        $this->assertSame(-2, $item->sell_in);
    }
}
