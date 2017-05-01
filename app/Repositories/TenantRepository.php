<?php


namespace App\Repositories;

class TenantRepository extends AbstractRepository {


    protected function definedModel() {
        return new \App\Tenant();
    }

    

    public function withChildren() {

        $this->model = $this->model->with('TenantAddress');
       
        return $this;
    }


    
}