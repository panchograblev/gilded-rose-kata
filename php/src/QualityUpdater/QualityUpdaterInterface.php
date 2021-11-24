<?php

declare(strict_types=1);

namespace GildedRose\QualityUpdater;

use GildedRose\Item;

interface QualityUpdaterInterface
{
    public function updateQuality(Item $item): void;
}
