<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    public function scopeRoot(Builder $builder): Builder
    {
        return $builder->whereNull('parent_id');
    }

    public function scopeDefaultOrder(Builder $builder): Builder
    {
        return $builder->orderBy('order', 'ASC');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this
            ->hasMany(self::class, 'parent_id')
            ->defaultOrder();
    }

    /**
     * boot
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (MenuItem $menuItem) {
            if ($menuItem->children->isEmpty()) {
                return;
            }

            foreach ($menuItem->children as $subMenu) {
                $subMenu->delete();
            }
        });
    }
}
