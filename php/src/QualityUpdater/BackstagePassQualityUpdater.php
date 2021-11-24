<?php

declare(strict_types=1);

namespace GildedRose\QualityUpdater;

use GildedRose\Item;

final class BackstagePassQualityUpdater implements QualityUpdaterInterface
{
    public function updateQuality(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality++;

            if ($item->sell_in < 11) {
                if ($item->quality < 50) {
                    $item->quality++;
                }
            }
            if ($item->sell_in < 6) {
                if ($item->quality < 50) {
                    $item->quality++;
                }
            }
        }

        $item->sell_in--;

        if ($item->sell_in < 0) {
            $item->quality = 0;
        }
    }
}
