<?php

namespace App\Http\Controllers;

use App\Http\Requests\VillaForm;

use App\Selection;
use App\Services\Result;

use App\Villa;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;

class VillaController extends Controller
{

    protected $villa;

    protected $selection;

    public function __construct() {
        
        $this->villa = new Villa();
        $this->selection = new Selection();

        $this->middleware('auth');



    }


    public function index() {


        return view("villa.index");

    }

    public function register($id = 0) {

        return view("villa.create",compact('id'));
    }

    /**********************API****************************/
    public function apiList($status = '') {

        return [

            "data"      =>  $this->villa->getLists(),

            "counts"    =>  $this->villa->statusCount()

        ];
    }

    public function apiSearch($filterKey,$filterValue = "") {
        
        $value = $this->villa->explicitSearch($filterKey,$filterValue)->get();

        return $value;

    }


    public function apiEdit($id) {

        $villa = [
            "data"      =>  $this->villa->withGalleries()->find($id),
            "lookups"   =>  $this->selection->getSelections(array("villa_type","villa_location"))
        ];

        $villaObject = $villa['data'];

        return $villa;
    }

    public function apiVacant() {

        return $this->villa->vacantOnly()->get();
    }

    public function apiCreate() {
        return 
        [
            "data"      =>  $this->villa->createInstance(),
            "lookups"   => $this->selection->getSelections(array("villa_type","villa_location"))
        ];
    }

    public function apiStore(VillaForm $request)
    {
        
        $inputs = $request->filterInput();
        
        try { 

            //get gallery files
            $files =   isset($inputs['galleries']) ? $inputs['galleries'] : [];
            
            $inputs['galleries'] = $this->storeImages($files,$inputs['villa_no']);
            
            $inputs['id'] = 0;
            
            $this->villa->saveVilla($inputs);

        }
        catch(Exception $e) {
            abort('500',$e);
        }

        return Result::ok();
    }

    public function apiUpdate(VillaForm $request) {

        $inputs = $request->filterInput();

        try {
            //get gallery files
            $files =   isset($inputs['galleries']) ? $inputs['galleries'] : [];
            $inputs['galleries'] = $this->storeImages($files,$inputs['villa_no']);
            $this->villa->saveVilla($inputs);
        }
        catch(Exception $e) {
            abort('500',$e);
        }

        return Result::ok();
    }

    public function apiDestroy($id) {
        
        $this->villa->find($id)->delete();

        return Result::ok('Successfully Deleted');
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
