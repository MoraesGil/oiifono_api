<?php

use Illuminate\Database\Seeder;
use App\Entities\Pathology;
use App\Entities\ActingArea;
use App\Entities\Strategy;

class TherapyBaseSeeder extends Seeder
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

        if (DB::table('acting_areas')->count() < count($actingAreas)){
            foreach ($actingAreas as $value) {
                ActingArea::create(["label"=>$value]);
            }
        }

        // if(Pathology::count() < 500)
        // factory(Pathology::class,500)->create();
        if(Strategy::count() < 30)
        factory(Strategy::class,30)->create();
    }
}
