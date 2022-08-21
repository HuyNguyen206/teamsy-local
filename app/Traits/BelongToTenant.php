<?php

namespace App\Traits;

use App\Models\Tenant;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

trait BelongToTenant {
    protected static function bootBelongToTenant()
    {
        static::addGlobalScope(new TenantScope());
        static::creating(function (Model $user) {
            if ($tenantId = session('tenant_id')) {
                $user->tenant_id = $tenantId;
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
