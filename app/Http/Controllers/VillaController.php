<?php

namespace App\Http\Controllers;

use App\Http\Requests\VillaForm;

use App\Services\Result;

use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class VillaController extends Controller
{

    protected $villa;

    protected $selection;

    public function __construct(
        \App\Repositories\VillaRepository $villa, 
        \App\Repositories\SelectionRepository $selection) {
        
        $this->villa = $villa;

        $this->selection = $selection;

    }

    /**********************API****************************/
    public function index($status = '') {

        return [
            "data"      =>  $this->villa->getVillas(),
            "counts"    =>  $this->villa->getStatusCount()
        ];
    }

    public function search($filterKey,$filterValue = "") {
        
        $value = $this->villa->dynamicSearch($filterKey,$filterValue)->get();

        return $value;

    }


    public function edit($id) {
        
        $villa = [ 
            "data"      =>  $this->villa->withChildren()->single($id),
            "lookups"   =>  $this->selection->getSelections(array("villa_type","villa_location"))
        ];
        
        $villaObject = $villa['data'];
        
        foreach($villaObject->villaGalleries as $gallery) {
                $gallery->image_name = asset('img/villa').'/'.$gallery->image_name; 
        }
        
        return $villa;
    }

    public function vacant() {

        return $this->villa->withStatus("vacant")->get();
    }

    public function create() {
        return 
        [
            "data"      =>  $this->villa->create(),
            "lookups"   => $this->selection->getSelections(array("villa_type","villa_location"))
        ];
    }

    public function store(VillaForm $request) 
    {
        
        $inputs = $request->filterInput();

        try { 
            //get gallery files
            $files =   isset($inputs['galleries']) ? $inputs['galleries'] : [];
            $inputs['galleries'] = $this->storeImages($files,$inputs['villa_no']);
            $this->villa->saveVilla($inputs,'create');
        }
        catch(Exception $e) {
            abort('500',$e);
        }

        return Result::ok();
    }

    public function update(VillaForm $request) {

        $inputs = $request->filterInput();
        try {
            //get gallery files
            $files =   isset($inputs['galleries']) ? $inputs['galleries'] : [];
            $inputs['galleries'] = $this->storeImages($files,$inputs['villa_no']);
            $this->villa->saveVilla($inputs,'modify');
        }
        catch(Exception $e) {
            abort('500',$e);
        }

        return Result::ok();
    }

    public function destroy($id) {
        
        $this->repository
            ->findById($id)
            ->markDeleted()
            ->saveChanges();

        $result = ["isOk" => true];
    }

    private function storeImages($files,$villaNo) {
        $galleries = array();
        
        if(sizeof($files) > 0) {

            foreach($files as $file) {

                $rules = ['file' => 'required|mimes:png,gif,jpeg']; //image only;
                $validator = Validator::make(array('file' => $file),$rules);

                if($validator->passes()) {
                    
                    //store it
                    $destinationPath = 'img/villa';
                    $origFileName = $villaNo.Carbon::now();
                    $fileName = hash("md5",$origFileName);  //$file->getClientOriginalName();
                    $uploadSuccess = $file->move($destinationPath,$fileName);
                    
                    //save rule
                    $galleries[] = array(
                        'image_name'    =>  $fileName,
                        'mime_type'     =>  $file->getClientMimeType()
                    );
                }
            }
        }

        return $galleries;
    }
    
}
