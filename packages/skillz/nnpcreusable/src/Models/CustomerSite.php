<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSite extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'site_name',
        'customer_id',
        'site_email',
        'site_address',
        'site_state_id',
        'site_lga_id',
        'site_zone_id',
        'is_active',
    ];
}
