<?php

use App\User;

if (! function_exists('getUser')) {
    function getUser(int $id): ?object
    {
        return User::find($id);
    }
}

if (! function_exists('getFolders')) {
    function getFolders(string $path, string $innerFolder = '')
    {
        if (is_dir(base_path($path))) {
            $folderList = scandir(base_path($path));
            $modules = [];
            foreach ($folderList as $folder)
                if (substr($folder, 0, 1) != '.')
                    $modules[] = $path . "\\$folder" . $innerFolder;
            return $modules;
        }
        return [];
    }
}

if (! function_exists('awsUrl')) {
    function awsUrl()
    {
        return env('AWS_URL') . '/' . env('AWS_BUCKET') . '/';
    }
}
