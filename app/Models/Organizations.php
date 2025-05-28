<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Organizations extends Model
{
    use HasFactory;
    protected $table = 'organizations';
    protected $primaryKey = 'id';

    public function parent()
    {
        return $this->belongsTo(Organizations::class, 'organization_parent_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'organization_id');
    }
}
