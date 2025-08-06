<?php

namespace App\Enums;

enum StockStatus: string
{
    case IN_STOCK = 'in_stock';
    case LOW_STOCK = 'low_stock';
    case OUT_OF_STOCK = 'out_of_stock';
    case DISCONTINUED = 'discontinued';

    public function label(): string
    {
        return match($this) {
            self::IN_STOCK => 'متوفر',
            self::LOW_STOCK => 'مخزون منخفض',
            self::OUT_OF_STOCK => 'نفذ المخزون',
            self::DISCONTINUED => 'متوقف',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::IN_STOCK => 'green',
            self::LOW_STOCK => 'yellow',
            self::OUT_OF_STOCK => 'red',
            self::DISCONTINUED => 'gray',
        };
    }

    public static function fromQuantity(int $quantity, int $lowStockThreshold = 10): self
    {
        return match(true) {
            $quantity <= 0 => self::OUT_OF_STOCK,
            $quantity <= $lowStockThreshold => self::LOW_STOCK,
            default => self::IN_STOCK,
        };
    }

    public static function options(): array
    {
        return array_map(
            fn(self $status) => ['value' => $status->value, 'label' => $status->label()],
            self::cases()
        );
    }
}
