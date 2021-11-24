<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\QualityUpdater\AgedBrieQualityUpdater;
use GildedRose\QualityUpdater\BackstagePassQualityUpdater;
use GildedRose\QualityUpdater\DefaultQualityUpdater;
use GildedRose\QualityUpdater\QualityUpdaterInterface;
use GildedRose\QualityUpdater\SulfurasQualityUpdater;

final class GildedRose
{
    /**
     * @var string
     */
    private const AGED_BRIE = 'Aged Brie';

    /**
     * @var string
     */
    private const BACKSTAGE_PASS = 'Backstage passes to a TAFKAL80ETC concert';

    /**
     * @var string
     */
    private const SULFURAS = 'Sulfuras, Hand of Ragnaros';

    /**
     * @var Item[]
     */
    private $items;

    /**
     * @var string[]
     */
    private $map = [
        self::AGED_BRIE => AgedBrieQualityUpdater::class,
        self::BACKSTAGE_PASS => BackstagePassQualityUpdater::class,
        self::SULFURAS => SulfurasQualityUpdater::class,
    ];

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $className = $this->map[$item->name] ?? DefaultQualityUpdater::class;

            /** @var QualityUpdaterInterface $updater */
            $updater = new $className();
            $updater->updateQuality($item);
        }
    }
}
