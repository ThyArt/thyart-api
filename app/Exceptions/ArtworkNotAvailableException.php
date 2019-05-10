<?php

namespace App\Exceptions;

use App\Artwork;
use Exception;

class ArtworkNotAvailableException extends Exception
{
    protected $artwork;
    /**
     * ArtworkNotAvailableException constructor.
     * @param $artwork
    */
    public function __construct(Artwork $artwork)
    {
        $this->message = 'Cannot create an order with the artwork '
            . $artwork->name . ' (' . $artwork->ref . ').'
            . ' current state is ' . $artwork->state . '.';
    }
}
