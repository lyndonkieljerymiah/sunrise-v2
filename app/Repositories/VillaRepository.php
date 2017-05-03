<?php

namespace App\Repositories;

use App\VillaGallery;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class VillaRepository extends AbstractRepository {

    protected $villaObject;

    protected $statusCount;

    protected $isCreate = false;

    protected $childrenName = ["villa_galleries"];


    protected function definedModel() {

        return new \App\Villa();
    }


    

    public function withChildren() {

        $this->model = $this->model->with('villaGalleries');
       
        return $this;
    }

    public function getVillas() {

        return $this->model->getLists();

    }

    public function getStatusCount() {
        
       return $this->model->statusCount();

    }

    public function setOccupied() {

        $this->model->setToOccupied();

        $this->saveChanges();

        return true;
    }

    public function setVacant() {
        
        $this->model->setToVacant();

        $this->saveChanges();

        return true;
    }

    /**
     * @param array $model
     * @return bool
     */
    public function saveGallery($model = array()) {
        try{

            $gallery = new \App\VillaGallery();
            $gallery->create($model);
        }
        catch(Exception $e) {
            dd($e->getMessage());
        }

        return true;
    }

    public function saveVilla($viewInputs,$mode) {

        try {
            
            $collectionGallery = isset($viewInputs['galleries']) ? $viewInputs['galleries'] : [];
            $villaGalleries = isset($viewInputs['villa_galleries']) ?  $viewInputs['villa_galleries'] : [];

            unset($viewInputs['galleries']);
            unset($viewInputs['villa_galleries']);

            if($mode == "modify") {
               $villaModel = $this->model->find($viewInputs['id']);
               $villaModel->toMap($viewInputs)->toSave();
            }
            else {
                $viewInputs['status'] = 'vacant';
                $villaModel->toMap($viewInputs)->toUpdate();
            }

            //save collection
            if(sizeof($collectionGallery) > 0) {

                $villaModel->villaGalleries()->saveMany(array_map(function($item) {
                    return new VillaGallery($item);
                },$collectionGallery));
            }
        }
        catch(Exception $e) {
            abort(500,$e->getMessage());
        }

        return true;

    }


    public function create($defaults = array()) {

        $this->model->location = "sv1";
        $this->model->villa_no = "";
        $this->model->electricity_no = "";
        $this->model->water_no = "";
        $this->model->qtel_no = "";
        $this->model->description = "";
        $this->model->capacity = "0";
        $this->model->villa_class = "ff";
        $this->model->rate_per_month = "0.00";

        return  $this->model;

    }

    protected function beforeCreate() {

        $this->emptyModel['status'] = "vacant"; //default

    }

   

    
}

