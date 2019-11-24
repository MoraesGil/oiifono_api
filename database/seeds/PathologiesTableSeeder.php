
<?php

use Illuminate\Database\Seeder;

use App\Entities\Pathology;
use League\Flysystem\File;

class PathologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $fileName = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'JsonSamples'. DIRECTORY_SEPARATOR. 'cid10_patologies.json';

        $pathologies = Collect((file_exists($fileName)) ? json_decode(File::get($fileName), true) : []);

        if (DB::table('pathologies')->count() === $pathologies->count())
            return;

        foreach ($pathologies as $pathology) {
            Pathology::updateOrCreate($pathology);
        }
    }
}
