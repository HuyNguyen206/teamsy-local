<?php

namespace App\Models;

use App\Traits\BelongToTenant;

class Document extends BaseModel
{
    use BelongToTenant;
}
