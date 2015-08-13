<?php

namespace Xkye;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model implements SluggableInterface
{
    use SoftDeletes, SluggableTrait;

    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'pivot'];

    protected $casts = [
        'id' => 'integer'
    ];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * Softdelete column.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Parent touches timestamp.
     *
     * @var array
     */
    protected $touches = ['projects'];


    /**
     * Projects relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany('Xkye\Project', 'category_projects')->withTimestamps();
    }

    public function scopeGenerate($scope, $name, $description = '')
    {
        return $this->create([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function scopeSearch($scope, $category)
    {
        return (!is_numeric($category)) ? $this->findBySlug($category) : $this->find($category);
    }
}
