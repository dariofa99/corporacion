<?php

namespace App\Http\Controllers;

use App\Models\PaymentCredit;
use App\Models\CaseM;
use Illuminate\Http\Request;
use App\Models\ReferenceData;
use App\Models\ReferenceDataOptions;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReferencesDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ver_categorias',   ['only' => ['index']]);
        $this->middleware('permission:crear_categorias',   ['only' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->getCategories();
        return view('content.categories.index', compact('categories'));
    }

    public function getCategories()
    {

        return  ReferenceData::orderBy('categories', 'asc')->where('is_visible', 1)->get();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json($request->all());
        $messages = [
            'name.unique' => 'El nombre  ya existe.',
            'name.required' => 'El nombre es requerido.',
        ];
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'unique:references_data'],
            ],
            $messages,
        );

        if ($validator->fails()) {
            if ($request->header('X-Requested-With') == 'XMLHttpRequest') {
                //return response()->json(errors$validator);
                return response()->json(['errors' => $validator->errors()->all()]);
            }
        }
        if ($request->categories == 'type_category_log') {
            $request['table'] = 'case_log';
            $request['section'] = null;
        }
        if ($request->categories == 'type_data_user') $request['table'] = 'users';
        if ($request->categories == 'type_data_directory') {
            $request['table'] = 'directory';
            $request['section'] = null;
        }
        $request["short_name"] = sanear_string($request->name);
        $request["section"] = $request->has("section") ? $request->section : "general";
        //        return response()->json($request->all());
        $referencia = new ReferenceData($request->all());
        $referencia->save();
        if ($request->has('option_name')) {
            foreach ($request->option_name as $key => $option) {
                $insrefeop = ReferenceDataOptions::create([
                    'value' => $option,
                    'value_db' => sanear_string($option),
                    'references_data_id' => $referencia->id,
                    'active_other_input' => $request->active_other_input[$key]
                ]);
            }
        }
        $categories = $this->getCategories();
        $view =  view('content.categories.partials.ajax.index', compact('categories'))->render();
        $response = [];
        $response['render_view'] = $view;
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referencia = ReferenceData::find($id);
        $referencia->options;
        return response()->json($referencia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return response()->json($request->all()); 
        $referencia = ReferenceData::find($id);
        $request["short_name"] = sanear_string($request->name);

        // $referencia->options;
        //return response()->json([$request->all(),$referencia]);
        if ($request->has('itemsDelete')) {
            $option_o = ReferenceDataOptions::whereIn("id", $request->itemsDelete)
                ->delete();
        }
        if ($referencia->type_data_id != $request->type_data_id) {
            if ($request->type_data_id == 26 or $request->type_data_id == 146) {
                $option_o = ReferenceDataOptions::where('references_data_id', $referencia->id)->delete();
            }
        }
        $referencia->fill($request->all());
        $referencia->save();
        if ($request->has('option_name')) {
            foreach ($request->option_name as $key => $option) {
                if (isset($request->options_id[$key]) and $request->options_id[$key] != 'null') {
                    $option_o = ReferenceDataOptions::find($request->options_id[$key]);
                    if ($option_o) {
                        $option_o->value = $option;
                        $option_o->value_db = sanear_string($option);
                        $option_o->active_other_input = $request->active_other_input[$key];
                        $option_o->save();
                    } else {
                        $insrefeop = ReferenceDataOptions::create([
                            'value' => $option,
                            'value_db' => sanear_string($option),
                            'references_data_id' => $referencia->id,
                            'active_other_input' => $request->active_other_input[$key]
                        ]);
                    }
                } else {
                    $insrefeop = ReferenceDataOptions::create([
                        'value' => $option,
                        'value_db' => sanear_string($option),
                        'references_data_id' => $referencia->id,
                        'active_other_input' => $request->active_other_input[$key]
                    ]);
                }
            }
        } elseif (count($referencia->options) > 0 and !$request->has('option_name')) {
            $referencia->options()->delete();
        }
        $categories = $this->getCategories();
        $view =  view('content.categories.partials.ajax.index', compact('categories'))->render();
        $response = [];
        $response['render_view'] = $view;
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referencia = ReferenceData::find($id);
        $exists_l = $referencia->logs()->where('case_log.type_category_id', $id)->exists();
        $exists_u = $referencia->users()->where('user_data.type_data_id', $id)->exists();
        if (!$exists_l and !$exists_u) {

            $referencia->is_visible = 0;
            $referencia->save();
        }

        $categories = $this->getCategories();
        $view =  view('content.categories.partials.ajax.index', compact('categories'))->render();
        $response = [];
        $response['render_view'] = $view;
        return response()->json($response);
    }
}
