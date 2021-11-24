<?php

declare(strict_types=1);

namespace GildedRose\QualityUpdater;

use GildedRose\Item;

final class SulfurasQualityUpdater implements QualityUpdaterInterface
{
    public function updateQuality(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality++;
        }
    }
}
