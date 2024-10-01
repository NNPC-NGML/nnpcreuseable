<?php

namespace Skillz\Nnpcreusable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSite extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        "customer_id",
        "site_address",
        "ngml_zone_id",
        "site_name",
        "phone_number",
        "email",
        "site_contact_person_name",
        "site_contact_person_email",
        "site_contact_person_phone_number",
        "site_contact_person_signature",
        "site_existing_status",
        "created_by_user_id",
        "status",
    ];
}
