<?php

namespace WithCandour\AardvarkSeo\Storage;

use Statamic\Facades\YAML;
use Statamic\Facades\File;

class GlobalsStorage implements Storage
{
    const prefix = 'aardvark';

    /**
     * Retrieve YAML data from storage
     *
     * @param string $handle
     * @param bool $returnCollection
     *
     * @return array
     */
    public static function getYaml(string $handle, bool $returnCollection = false)
    {
        $path = storage_path(implode("/", [
            'statamic/addons/aardvark-seo',
            self::prefix . '_' . "{$handle}.yaml"
        ]));

        $data = YAML::parse(File::get($path));

        if ($returnCollection) {
            return collect($data);
        }

        return $data;
    }

    /**
     * Put YAML data into storage
     *
     * @param string $handle
     * @param array $data
     *
     * @return void
     */
    public static function putYaml(string $handle, array $data)
    {
        $path = storage_path(implode("/", [
            'statamic/addons/aardvark-seo',
            self::prefix . '_' . "{$handle}.yaml"
        ]));

        File::put($path, YAML::dump($data));
    }
}