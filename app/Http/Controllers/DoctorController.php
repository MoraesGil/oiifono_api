    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Entities\Person;


    class DoctorController extends Controller
    {

        public function index(Request $request)
        {
            if ($request->expectsJson() || ($request->get("json") != null && env('APP_DEBUG', false))) {
                return $this->getData($request);
            }
            return $this->indexRedirectRouteName ? redirect()->route($this->indexRedirectRouteName) : $this->getPage();
        }

        private function getPage()
        {
            return view($this->indexView, $this->indexData);
        }


        private function getData(Request $request)
        {
            if ($this->modelGetMethodName) {
                return response()->json($this->Model()->{$this->modelGetMethodName}($request->all()), 200);
            }
            return response()->json($this->Model()->paginate($request->get("limit")), 200);
        }

        public function store(Request $request)
        {
            $isIndividual = $request->get("cpf");
            $data = $request->all();
            $data = $request->all();
            DB::transaction(function () use ($data, $isIndividual) {
                return response()->json(
                    ($isIndividual ?
                        Individual::create($data) : Company::create($data))->person()->create($data),
                    201
                );
            });

            return response()->json($this->Model()->create($request->all()), 201);
        }

        public function show($id)
        {
            return $this->Model()->findOrFail($id);
        }


        public function update(Request $request, $id)
        {
            if ($this->Model()->hasRules()) {
                if (!$this->Model()->validate($request->all(), $id)) {
                    return response()->json($this->Model()->errors, 400);
                }
            }
            return response()->json($this->Model()->findOrFail($id)->update($request->all()), 200);
        }


        public function destroy(Request $request, $id)
        {
            return response()->json($this->Model()->findOrFail($id)->delete(), 204);
        }
    }
