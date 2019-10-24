<?php

use Illuminate\Database\Seeder;

use App\Entities\State;

class StatesTableSeeder extends Seeder {
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()   {
    if(DB::table('states')->count() === 27)
    return true;
    State::updateOrCreate(['uf'=>'AC'],['uf'=>'AC','name'=>'Acre']);
    State::updateOrCreate(['uf'=>'AL'],['uf'=>'AL','name'=>'Alagoas']);
    State::updateOrCreate(['uf'=>'AP'],['uf'=>'AP','name'=>'Amapá']);
    State::updateOrCreate(['uf'=>'AM'],['uf'=>'AM','name'=>'Amazonas']);
    State::updateOrCreate(['uf'=>'BA'],['uf'=>'BA','name'=>'Bahia']);
    State::updateOrCreate(['uf'=>'CE'],['uf'=>'CE','name'=>'Ceará']);
    State::updateOrCreate(['uf'=>'DF'],['uf'=>'DF','name'=>'Distrito Federal']);
    State::updateOrCreate(['uf'=>'ES'],['uf'=>'ES','name'=>'Espírito Santo']);
    State::updateOrCreate(['uf'=>'GO'],['uf'=>'GO','name'=>'Goiás']);
    State::updateOrCreate(['uf'=>'MA'],['uf'=>'MA','name'=>'Maranhão']);
    State::updateOrCreate(['uf'=>'MT'],['uf'=>'MT','name'=>'Mato Grosso']);
    State::updateOrCreate(['uf'=>'MS'],['uf'=>'MS','name'=>'Mato Grosso do Sul']);
    State::updateOrCreate(['uf'=>'MG'],['uf'=>'MG','name'=>'Minas Gerais']);
    State::updateOrCreate(['uf'=>'PA'],['uf'=>'PA','name'=>'Pará']);
    State::updateOrCreate(['uf'=>'PB'],['uf'=>'PB','name'=>'Paraíba']);
    State::updateOrCreate(['uf'=>'PR'],['uf'=>'PR','name'=>'Paraná']);
    State::updateOrCreate(['uf'=>'PE'],['uf'=>'PE','name'=>'Pernambuco']);
    State::updateOrCreate(['uf'=>'PI'],['uf'=>'PI','name'=>'Piauí']);
    State::updateOrCreate(['uf'=>'RJ'],['uf'=>'RJ','name'=>'Rio de Janeiro']);
    State::updateOrCreate(['uf'=>'RN'],['uf'=>'RN','name'=>'Rio Grande do Norte']);
    State::updateOrCreate(['uf'=>'RS'],['uf'=>'RS','name'=>'Rio Grande do Sul']);
    State::updateOrCreate(['uf'=>'RO'],['uf'=>'RO','name'=>'Rondônia']);
    State::updateOrCreate(['uf'=>'RR'],['uf'=>'RR','name'=>'Roraima']);
    State::updateOrCreate(['uf'=>'SC'],['uf'=>'SC','name'=>'Santa Catarina']);
    State::updateOrCreate(['uf'=>'SP'],['uf'=>'SP','name'=>'São Paulo']);
    State::updateOrCreate(['uf'=>'SE'],['uf'=>'SE','name'=>'Sergipe']);
    State::updateOrCreate(['uf'=>'TO'],['uf'=>'TO','name'=>'Tocantins']);

  }
}
