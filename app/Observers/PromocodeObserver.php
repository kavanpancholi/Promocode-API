<?php

namespace App\Observers;

use App\Models\Promocode;

class PromocodeObserver
{
    /**
     * @param Promocode $promocode
     */
    public function deleting(Promocode $promocode)
    {
        $promocode->events()->detach();
    }
}
