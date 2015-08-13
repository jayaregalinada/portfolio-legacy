<?php

namespace Xkye;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;

class Project extends Model
{

    protected $table = 'projects';

    protected $fillable = ['name', 'description', 'thumbnail_id'];

    protected $hidden = ['thumbnail_id', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'integer',
        'thumbnail_id' => 'integer'
    ];

    protected $appends = [
        'thumbnail',
        'category'
    ];

    protected $with = [
        'categories'
    ];

    public function categories()
    {
        return $this->belongsToMany('Xkye\Category', 'category_projects')->withTimestamps();
    }

    public function getCategoryAttribute()
    {
        return $this->categories()->first();
    }

    public function images()
    {
        return $this->morphMany('Xkye\Image', 'imageable');
    }

    /**
     * Get the Thumbnail.
     * Check if in column `thumbnail_id` exists in images table.
     *
     * @return object|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getThumbnail()
    {
        if( $this->images()->whereId( $this->thumbnail_id )->exists() ) {
            return $this->images()->whereId( $this->thumbnail_id )->first();
        }

        return $this->images->first();
    }

    /**
     * Attributes for `thumbnail`.
     *
     * @return array
     */
    public function getThumbnailAttribute()
    {
        if( is_null( $this->getThumbnail()['sizes'] ) ) {
            return $this->defaultThumbnail();
        }

        return $this->getThumbnail()['sizes'];
    }

    /**
     * Convert the Description into HTML.
     *
     * @return string
     */
    public function getDescriptionAttribute($value)
    {
        $c = new CommonMarkConverter();

        return $c->convertToHtml($value);
    }

    /**
     * Return a raw description with Markdown.
     *
     * @return string
     */
    public function rawDescription()
    {
        return $this->original['description'];
    }

    /**
     * @return array
     */
    private function defaultThumbnail()
    {
        $path = '/images/defaults/projects/project_';

        return [
            $this->generateDefaultThumbnail( 600, $path . 'org.jpg' ),
            $this->generateDefaultThumbnail( 50,  $path . 'sqr.jpg' ),
            $this->generateDefaultThumbnail( 280, $path . 'thn.jpg' ),
            $this->generateDefaultThumbnail( 150, $path . 'sml.jpg' ),
            $this->generateDefaultThumbnail( 300, $path . 'mdm.jpg' ),
            $this->generateDefaultThumbnail( 600, $path . 'lrg.jpg' )
        ];
    }

    /**
     * @param $size
     * @param $path
     *
     * @return array
     */
    private function generateDefaultThumbnail( $size, $path )
    {
        return [
            'width' => $size,
            'height' => $size,
            'url' => url( $path ),
            'base_dir' => $path
        ];
    }
}
