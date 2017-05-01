<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends BaseModel
{
    //

    public function Address() {
        return $this->hasOne(TenantAddress::class);
    }

    public function createNewModel() {
        $tenant = new Tenant();
        
        $tenant->type = "individual";
        $tenant->code = "";
        $tenant->full_name = "";
        $tenant->email_address = "";
        $tenant->tel_no = "";
        $tenant->mobile_no = "";
        $tenant->fax_no = "";
        $tenant->reg_date = "";
        $tenant->gender = "Male";
        $tenant->reg_id = "";
        $tenant->reg_name = "";

        return $tenant;

    }

}
