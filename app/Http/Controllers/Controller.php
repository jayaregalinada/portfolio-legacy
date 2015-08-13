<?php

namespace Xkye\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Jag\Common\Traits\ControllerResponsesTrait;

abstract class Controller extends BaseController
{
    use ValidatesRequests, ControllerResponsesTrait;
}
