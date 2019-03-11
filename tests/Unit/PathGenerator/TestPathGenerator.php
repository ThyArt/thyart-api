<?php
/**
 * Created by PhpStorm.
 * User: clementdeseine
 * Date: 2019-03-11
 * Time: 16:22
 */
namespace Tests\Unit\PathGenerator;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class TestPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return 'tests/' . $this->getBasePath($media).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return 'tests/' . $this->getBasePath($media).'/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return 'tests/' . $this->getBasePath($media).'/';
    }

    protected function getBasePath(Media $media): string
    {
        return $media->getKey();
    }
}
