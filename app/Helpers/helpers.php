<?php

if (!function_exists('temp_asset')) {
    /**
     * Get a temporary URL for a private storage asset.
     *
     * @param string|null $path
     * @return string|null
     */
    function temp_asset($path)
    {
        if ($path == null) {
            return null;
        }
        return \Illuminate\Support\Facades\Storage::temporaryUrl($path, now()->addMinutes(5));
    }
}
