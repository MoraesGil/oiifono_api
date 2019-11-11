<?php

namespace App\Helpers\Traits\Conrtrollers;

use Illuminate\Http\Request;

trait ApiRestfulTrait
{
    // define a model object
    protected $Model                  = null;
    // define a model name
    protected $modelName              = "";
    // define a model name
    protected $modelNamespace         = "Entities";
    //define a getMethodName for getData
    protected $modelGetMethodName     = "";

    /**
     * Returns a instance of Model with same Controller name, from Entities folder
     * @return [Model] [Entity Instance]
     */
    protected function Model()
    {
        if ($this->Model == null) {
            $classPath = str_replace_last("Http\Controllers", $this->modelNamespace, get_class());
            $class = $this->modelName ? str_replace_last((new \ReflectionClass($this))->getShortName(), $this->modelName, $classPath) : str_replace_last("Controller", "", $classPath); //$modelName;
            $this->Model = new $class();
        }
        return $this->Model;
    }

    /**
     * GM - Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getData($request);
    }


    /*
  * [getData description]
  * @param  Request $request  [description]
  * @param  integer $paginate [description]
  * @return [type]            [description]
  */
    private function getData(Request $request)
    {
        if ($this->modelGetMethodName) {
            return response()->json($this->Model()->{$this->modelGetMethodName}($request->all()), 200);
        }
        return response()->json($this->Model()->paginate($request->get("limit")?:15), 200);
    }

    /**
     * GM - Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($this->Model()->create($request->all()), 201);
    }

    /**
     * GM - Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->Model()->findOrFail($id);
    }

    /**
     * GM - Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->Model()->findOrFail($id)->update($request->all()), 200);
    }

    /**
     * GM - Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json($this->Model()->findOrFail($id)->delete(), 204);
    }
}
