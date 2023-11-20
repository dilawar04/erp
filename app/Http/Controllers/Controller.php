<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

//Todo::Dev
use function Composer\Autoload\includeFile;
if(\File::exists(theme_dir('includes/shortcodes.php', true))) {
    includeFile(theme_dir('includes/shortcodes.php', true));
}

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
