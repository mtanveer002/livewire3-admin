<?php

namespace App\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface Ownable
{
    /**
     * Check if the current model is owned by the given owner object.
     */
    public function isOwnedBy(Authenticatable $owner): bool;
}
