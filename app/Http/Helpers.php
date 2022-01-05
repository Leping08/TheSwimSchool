<?php

use Illuminate\Support\Facades\Storage;

/**
 * Function to get an asset from the S3 bucket path.
 * The project gets assets from both the public path 
 * which is the default path for the asset helper 
 * and the aws bucket path which is what this function
 * does.
 *
 * @param string $path
 * @return string
 */

if (! function_exists('aws_asset')) {
  function aws_asset($path) {
    return "https://theswimschool-bucket.s3.amazonaws.com/{$path}";
  };
};
