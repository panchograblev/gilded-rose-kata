<?php

declare(strict_types=1);

namespace GildedRose\QualityUpdater;

use GildedRose\Item;

final class AgedBrieQualityUpdater implements QualityUpdaterInterface
{
    public function updateQuality(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality++;
        }

        $item->sell_in--;

        if ($item->sell_in < 0) {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
            }
        }
    }
}
