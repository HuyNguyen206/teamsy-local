<?php

namespace App\Models;

use App\Traits\BelongToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable, BelongToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function getAvatar()
    {
        return $this->photo ?
            Storage::disk('s3-public')->url($this->photo)
            :  'https://avatars.dicebear.com/api/initials/' . $this->name . '.svg';
    }

    public function getDocument()
    {
        return $this->documents()->latest()->first();
    }

    public function getApplicationUrl($documentId)
    {
        return route('documents.show', $documentId);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%');
    }

    public function isSuperAdmin()
    {
        return $this->tenant_id === null;
    }
}
