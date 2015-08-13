<?php

namespace Xkye\Services\Project;

use Illuminate\Auth\Guard;
use League\CommonMark\CommonMarkConverter;
use Validator, File, Config;
use Xkye\Image;
use Xkye\Project;
use Xkye\Services\Project\ImageProcessor;

class Factory {

    /**
     * @var \Illuminate\Auth\Guard
     */
    protected $auth;

    /**
     * @var string
     */
    protected $date;

    /**
     * @var integer
     */
    protected $time;

    /**
     * @param  Guard  $auth
     * @param  Image  $image
     */
    public function __construct( Guard $auth, Image $image )
    {
        $this->auth = $auth;
        $this->date = date( "Y-n-d-His" );
        $this->time = time();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator( array $data )
    {
        return Validator::make( $data, [
            'name'          => 'required|max:255',
            'description'   => 'min:1'
        ] );
    }

    /**
     * Validate before creation
     *
     * @param  array  $data
     * @param  string $next
     *
     * @return \Illuminate\Http\Response
     */
    public function execute( $data, $next = null )
    {
        if( $this->validator( $data )->passes() )
        {
            $model = $this->create( $data );
            if($next) {
                return redirect( $next );
            }

            return $model;
        }

        return response( $this->validator()->messages(), 500 );
    }

    protected function create( $data )
    {
        return Project::create([
            'name'          => $data[ 'name' ],
            'description'   => $data[ 'description' ],
        ]);
    }

    /**
     * Create directory
     *
     * @param  string  $folderName
     *
     * @return boolean
     */
    public function createDirectory( $folderName )
    {
        if( ! File::exists( public_path(config('project.upload.basename')) . $folderName ) ) {
            return File::makeDirectory( public_path(config('project.upload.basename')) . $folderName, 0777, true );
        }

        return true;
    }

    /**
     * Compile images
     *
     * @param  string  $directory
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile  $file
     * @param  \Xkye\Services\Product\ImageProcessor  $processor
     *
     * @return array
     */
    public function compileImage( $directory, $file, ImageProcessor $processor )
    {
        $image = [];
        $quality = [
            'jpg'   => config( 'project.images.quality.jpg' ),
            'image' => config( 'project.images.quality.image' ),
        ];
        $saveDir = public_path(config( 'project.upload.basename' )) . $directory;

        $images = [
            // ORIGINAL SIZE
            $processor->encodeImage(
                $file,
                $saveDir . $this->createFileName( config( 'project.images.sizes.original.suffix' ), $file )
            ),
            // SQUARE SIZE
            $processor->createSquare(
                config( 'project.images.sizes.square.size' ),
                $file,
                $saveDir . $this->createFileName( config( 'project.images.sizes.square.suffix' ), $file )
            ),
            // THUMBNAIL SIZE
            $processor->createSquare(
                config( 'project.images.sizes.thumbnail.size' ),
                $file,
                $saveDir . $this->createFileName( config( 'project.images.sizes.thumbnail.suffix' ), $file )
            ),
            // SMALL SIZE
            $processor->resizeImage(
                [
                'width' => config( 'project.images.sizes.small.width' ),
                'height' => config( 'project.images.sizes.small.height' )
                ],
                $file,
                $saveDir . $this->createFileName( config( 'project.images.sizes.small.suffix' ), $file )
            ),
            // MEDIUM SIZE
            $processor->resizeImage(
                [
                'width' => config( 'project.images.sizes.medium.width' ),
                'height' => config( 'project.images.sizes.medium.height' )
                ],
                $file,
                $saveDir . $this->createFileName( config( 'project.images.sizes.medium.suffix' ), $file )
            ),
            // LARGE SIZE
            $processor->resizeImage(
                [
                'width' => config( 'project.images.sizes.large.width' ),
                'height' => config( 'project.images.sizes.large.height' )
                ],
                $file,
                $saveDir . $this->createFileName( config( 'project.images.sizes.large.suffix' ), $file )
            )
        ];

        foreach ( $images as $key => $value )
        {
            $image[] = [
                'width'     => $images[ $key ]->width(),
                'height'    => $images[ $key ]->height(),
                'url'       => config( 'project.upload.basename') . "$directory$value->basename",
                'base_dir'  => "$directory$value->basename"
            ];
        }

        return $image;
    }

    /**
     * Filename creation
     *
     * @param  string  $suffix
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile  $file
     * @param  string  $separator
     *
     * @return string
     */
    private function createFileName( $suffix, $file, $separator = '_' )
    {
        return $this->date . $separator . sha1( $file->getClientOriginalName() . $this->time ) . $separator . $suffix . '.jpg';
    }


}

