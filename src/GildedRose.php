<?php

namespace App;

final class GildedRose
{
    public function updateQuality($item): bool
    {
        if ($item->name === 'Sulfuras, Hand of Ragnaros') {
            $item->quality = 80;

            return true;
        }

        if ($this->checkIsNotAgedBrieAndBackstagePasses($item->name)) {
            $item->quality--;

            $item->quality = max($item->quality, 0);
        } elseif ($item->quality < 50) {
            $item->quality++;

            if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                $item->quality = $this->getQualityBySellIn($item, 11);
                $item->quality = $this->getQualityBySellIn($item, 6);
            }
        }

        $item->sell_in--;

        if ($item->sell_in < 0) {
            $item->quality = $this->getQualityAfterDecrementSellIn($item);
        }

        return true;
    }

    private function checkIsNotAgedBrieAndBackstagePasses($name): bool
    {
        return $name !== 'Aged Brie' && $name !== 'Backstage passes to a TAFKAL80ETC concert';
    }

    private function getQualityBySellIn($item, $sellInValue): int
    {
        if ($item->sell_in < $sellInValue && $item->quality < 50) {
            $item->quality++;
        }

        return $item->quality;
    }

    private function getQualityAfterDecrementSellIn($item): int
    {
        if ($item->name === 'Aged Brie') {
            $item->quality++;

            $item->quality = min($item->quality, 50);
        } elseif ($item->name !== 'Backstage passes to a TAFKAL80ETC concert') {
            $item->quality--;

            $item->quality = max($item->quality, 0);
        } else {
            $item->quality = 0;
        }

        return $item->quality;
    }
}
