<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavMain extends Model
{
    use HasFactory;

    /**
     * Get all of the navSub for the NavMain
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function navSub()
    {
        return $this->hasMany(NavSub::class, 'nav_main_id', 'id');
    }
}
