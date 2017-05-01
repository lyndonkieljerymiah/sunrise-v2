<?php

use Illuminate\Database\Seeder;

class VillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('villas')->delete();

        // seed villa -----------------------------
        for($i=0;$i <= 15;$i++) {

            $villa = new \App\Villa();
            $villa->created_at = \Carbon\Carbon::now();
            $villa->updated_at = \Carbon\Carbon::now();
            $villa->loaction = 'S01';
            $villa->villa_no = $villa->location . '-' . strlen((string)$i) == 1 ? '00'.$i : '0'.$i;
            $villa->electricity_no = "E0000".$i;
            $villa->water_no = "W0000".$i;
            $villa->qtel_no = "99957455".$i;
            $villa->villa_class = "ff";
            $villa->capacity = mt_rand(5,10);
            $villa->description = '800';
            $villa->status = 'vacant';

            $villa->save();

        }
    }
}
