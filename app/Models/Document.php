<?php

namespace App\Models;

use App\Traits\BelongToTenant;

class Document extends BaseModel
{
    use BelongToTenant;

    protected static $unguarded = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
