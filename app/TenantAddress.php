<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenantAddress extends BaseModel
{
    //
    public function __construct(array $attributes = [])
    {
        $this->address_1 = "";
        $this->address_2 = "";
        $this->city = "";
        $this->postal_code = "";

        parent::__construct($attributes);
    }

    public static function createInstance() {
        return new TenantAddress();

    }
}
