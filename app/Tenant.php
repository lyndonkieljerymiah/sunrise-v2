<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends BaseModel
{
    //

    public function __construct(array $attributes = [])
    {
        $this->type = "individual";
        $this->code = "";
        $this->full_name = "";
        $this->email_address = "";
        $this->tel_no = "";
        $this->mobile_no = "";
        $this->fax_no = "";
        $this->reg_date = \Carbon\Carbon::now()->toDateTimeString();
        $this->gender = "Male";
        $this->reg_id = "";
        $this->reg_name = "";

        parent::__construct($attributes);
    }

    public function Address() {
        return $this->hasOne(TenantAddress::class);
    }

    public static function createInstance() {
        $tenant = new Tenant();
        $tenant->address_instance = TenantAddress::createInstance();
        return $tenant;

    }

}
