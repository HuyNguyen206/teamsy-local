<?php

namespace App\Models;

use App\Traits\BelongToTenant;

class Login extends BaseModel
{
    use BelongToTenant;
    protected $guarded = [];
}
