<?php

use Illuminate\Database\Seeder;
use App\Entities\ActingArea;
class ActingAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $actingAreas = [
            "Audiologia",
            "Fonoaudiologia Educacional",
            "Linguagem",
            "Motricidade Orofacial",
            "Saúde Coletiva",
            "Disfagia",
            "Voz",
            "Fonoaudiologia Neurofuncional",
            "Fonoaudiologia do Trabalho",
            "Gerontologia",
            "Neuropsicologia"
        ];

        if (DB::table('acting_areas')->count() === count($actingAreas))
            return true;
        foreach ($actingAreas as $value) {
            ActingArea::create(["label"=>$value]);
        }
    }
}
