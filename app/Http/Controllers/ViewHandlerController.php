<?php

namespace Xkye\Http\Controllers;

use Illuminate\Http\Request;

use Xkye\Http\Requests;
use Xkye\Http\Controllers\Controller;

class ViewHandlerController extends Controller
{
    /**
     * @param $view
     *
     * @return \View|void
     */
    public function getViewsOfPublic( $view )
    {
        switch ( $view ) {
            default:
                return $this->__default( $view, '', 'public' );
            break;
        }
    }

    /**
     * @param $view
     *
     * @return \View|void
     */
    public function getDashboardViews( $type, $view )
    {
        return $this->__default( $view, $type );
    }

    /**
     * @param        $view
     * @param string $directory
     * @param bool   $root
     *
     * @return \View|void
     */
    private function __default( $view, $directory = '', $root = false )
    {
        $dir = ( $root ) ? $root : 'dashboard.';
        if( ! view()->exists( $dir . $directory .'.a_' . $view ) )
            return abort( 404, 'View not found' );

        return view( $dir . $directory .'.a_' . $view );
    }
}
