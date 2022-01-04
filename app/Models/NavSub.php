<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavSub extends Model
{
    use HasFactory;

    /**
     * Get the navMain that owns the NavSub
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function navMain()
    {
        return $this->belongsTo(NavMain::class, 'nav_main_id', 'id');
    }
    /**
     * Get all of the navSubUser for the NavSub
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function navSubUser()
    {
        return $this->hasMany(NavSubUser::class, 'nav_sub_id', 'id');
    }
}
