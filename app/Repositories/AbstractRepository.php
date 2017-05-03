<?php

namespace App\Repositories;

use Carbon\Carbon;

abstract class AbstractRepository {

    
    protected $model;

    protected $emptyModel;

    protected $hasNavigation;

    protected abstract function definedModel();

    public function __construct() {
        $this->model = $this->definedModel();
    }

    protected function beforeCreate() {return false;}
    
    protected function afterCreate() {return false;}

    public function findById($id) {

        $this->model = $this->model->find($id);

        return $this;
    }


    public function withStatus($status) {

         $this->model = $this->model->where('status',$status);

         return $this;
    }

     public function dynamicSearch($filterKey,$filterValue) {
        
        $this->model = $this->model->where($filterKey,$filterValue);
        
        return $this;
    }

    public function createInstance() {

        return $this->model->createInstance();
    }
  
    public function get($orderBy = 'id') {

        $records =  $this->model->where('is_active',1)->orderBy($orderBy)->get();

        $this->model = $this->definedModel();

        return $records;
    }

    public function first() {

        $records = $this->model->where('is_active',1)->first();

        $this->model = $this->definedModel();

        return $records;
    }

    public function single($id) {

        $record = $this->model->find($id);

        $this->model = $this->definedModel();

        return $record;
    }

    public function instance() {

        $model = $this->model;

        $this->model = $this->definedModel();

        return $model;
    }

    public function lastRecord() {

        return $this->model->orderBy('id','desc')->first();

    }
    


    //command operation*******************************************
    protected function clearChain() {

        $this->model = $this->definedModel();

        return $this;
    }

    /**
     * @param $model
     * @param string $state
     * @param array $exclude
     * @return $this
     */
    public function attach($model, $state = "auto", $exclude = array()) {

        $this->emptyModel = $model;

        if($state == "auto") {

            if(!isset($model['id']) || $model['id'] == 0) {
                $state = "create";
            }
            else {
                $state = "modify";
            }
        }
        
        
        try {

            if($state == "create") {

                $this->beforeCreate($model);

                $this->model->toMap($model)->toSave();

                $this->afterCreate();

            }
            else if($state == "modify") {

                $this->model = $this->single($model['id']);

                $this->model->toMap($model)->toUpdate();
            }

        }
        catch(Exception $e) {
            abort(500,$e->getMessage());
        }

        return $this;
    }

    public function softDeleted() {
        
        $this->model->is_active = 0;
        $this->model->toUpdate();

        return true;
    }

    public function createNewId() {

        $lastRecord = $this->model->orderBy('id','desc')->first();
        
        if($lastRecord == null) 
            return 1;

        return $lastRecord->id++;
    }



}