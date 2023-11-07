<?php

namespace App\Models;

use Dotlogics\Grapesjs\App\Contracts\Editable;
use Dotlogics\Grapesjs\App\Traits\EditableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property-read Collection $media
 */
class Page extends Model implements Editable, HasMedia
{
    use HasFactory,
        EditableTrait,
        HasSlug,
        InteractsWithMedia,
        SoftDeletes;

    const HOME_PAGE_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_published' => 'boolean',
        'header_white' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(100)
            ->doNotGenerateSlugsOnUpdate();
    }

    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('is_published', true);
    }

    public function scopeNotPublished(Builder $builder): Builder
    {
        return $builder->where('is_published', false);
    }

    public function scopeSearch(Builder $builder, string $query): Builder
    {
        return $builder->where(function (Builder $builder) use ($query) {
            $query = "%{$query}%";

            $builder->where('title', 'like', $query);
            $builder->orWhere('slug', 'like', $query);
            $builder->orWhere('meta_title', 'like', $query);
            $builder->orWhere('meta_keywords', 'like', $query);
            $builder->orWhere('meta_description', 'like', $query);
        });
    }

    public function isActive(): bool
    {
        return $this->deleted_at == null;
    }

    public function getTemplatesPath(): string
    {
        return 'templates';
    }
}
