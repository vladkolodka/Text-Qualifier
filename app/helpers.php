<?php

/**
 * Generate an asset path for the application.
 * @param $path
 * @return string Path to asset
 * @see asset
 */
function load($path){
    return app('url')->asset(config("view.assets_folder") . '/' . $path, false);
}