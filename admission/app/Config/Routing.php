<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Config\Routing as BaseRouting;

/**
 * Routing configuration
 */
class Routing extends BaseRouting
{

    public array $routeFiles = [
        APPPATH . 'Config/Routes.php',
    ];


    public string $defaultNamespace = 'App\Controllers';


    public string $defaultController = 'Home';


    public string $defaultMethod = 'index';


    public bool $translateURIDashes = false;


    public ?string $override404 = null;


    public bool $autoRoute = true;


    public bool $prioritize = false;


    public bool $multipleSegmentsOneParam = false;


    public array $moduleRoutes = [];


    public bool $translateUriToCamelCase = false;
}
