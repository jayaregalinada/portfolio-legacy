<?php

namespace Xkye;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $fillable = ['sizes', 'caption'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Change the sizes attribute into JSON or Array
     *
     * @param  object $value
     *
     * @return array
     */
    public function getSizesAttribute( $value )
    {
        $j = json_decode( $value, true );
        foreach ( $j as $key => $value )
        {
            $j[ $key ][ 'url' ] = url( $j[ $key ]['url'] );
        }

        return $j;
    }
}
