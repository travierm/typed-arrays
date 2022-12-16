<?php

namespace Tmoorlag\PhpTypedArrays;

use ArrayIterator;
use Tmoorlag\PhpTypedArrays\TypedArray;

class SongArray extends TypedArray
{
    public string $className = Song::class;

    public function current() : Song
    {
        return parent::current();
    }

    public function offsetGet($offset) : Song
    {
        return parent::offsetGet($offset);
    }

}

