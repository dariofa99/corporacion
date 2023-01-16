<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;
use App\Models\ReferenceTable;
use DB;
use Carbon\Carbon;
use Storage;

class LibraryController extends Controller
{
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('permission:access_dashboard_cases',   ['only' => ['index','edit']]);
    }
    
    public function index(Request $Request)
    {
 

        $arrayconsul=[];
        $sw_search=0;

        if ($Request->has(['name', 'branch_law','category'])) {
            $sw_search=1;
            if ($Request->filled('branch_law')) {
                $arrayconsul['type_branch_law_id']=$Request->branch_law;
            }
            if ($Request->filled('category')) {
                $arrayconsul['category_id']=$Request->category;
            }
  
        }      
 

        $library = Library::select('id','description','name_file','size','user_id','created_at')
        ->where($arrayconsul)->where('name_file','like',"%$Request->name%")
        ->where('type_status_id','<>',15) 
        ->paginate(30);
        $branch_law = ReferenceTable::where('categories','type_branch_law_library')->get();
        $category = ReferenceTable::where('categories','category_id')->get();


        return view('content.library.index',compact('library','branch_law','category','sw_search'));


    }

    public function show(Request $Request)
    {
        $owner="";
        $library = Library::join('users', 'library.user_id','=', 'users.id')
        ->join('references_table as rbl', 'type_branch_law_id', 'rbl.id')
        ->join('references_table as catl', 'category_id', 'catl.id')
        ->where('library.id',$Request->id)
        ->select('library.id as id','name_file','description','route_file','size','user_id','type_branch_law_id','category_id','limit_date','library.created_at', 'users.name as name', 'users.identification_number', 'users.image','rbl.name as ramader','catl.name as category')
        ->first();
            $library->owner = false;
        if ($library->user_id == \Auth::user()->id) {
            $library->owner = true;
        }

        return response()->json($library);
    }

    public function create(Request $request)
    {
   
        if($request->file('name_file')!=''){
           
            $docum = $request->file('name_file');
            $nombre_arch= $docum->getClientOriginalName();
            $nombre_arch = htmlentities($nombre_arch);
            $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
            $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
            $actdocnompropio= $file_name;    
            $extension = $docum->extension();
            $file_name = md5($file_name).'.'.$extension;
            $file_route = time()."_".$file_name;     
            $size = $request->file('name_file')->getSize();          
            Storage::disk('library_files')->put($file_route, file_get_contents($docum->getRealPath() ) );
            $complet_path =Storage::disk('library_files')->url($file_route);
            $libraryfile = new Library();
            $libraryfile->name_file = $docum->getClientOriginalName();   
            $libraryfile->description = $request->description;  
            $libraryfile->route_file =$complet_path;   
            $libraryfile->size = $size;  
            $libraryfile->type_status_id = 11;  
            $libraryfile->user_id = \Auth::user()->id;  
            $libraryfile->type_branch_law_id = $request->branch_law;  
            $libraryfile->category_id = $request->category;  
            $libraryfile->limit_date = $request->fecha_max;
            $libraryfile->save();                 
        }
        $library = Library::select('id','name_file','size','user_id','created_at')
        ->paginate(30); 
        $view = view('content.library.ajax.index',compact('library'))->render();

        return response()->json(['view'=>$view ]);
           
    }
    public function update(Request $request)
    {
        $libraryfile = Library::find($request->id);
        if ($libraryfile->user_id == \Auth::user()->id) {
        
            if($request->file('name_file')!=''){
           
                $docum = $request->file('name_file');
                $nombre_arch= $docum->getClientOriginalName();
                $nombre_arch = htmlentities($nombre_arch);
                $nombre_arch = preg_replace('/\&(.)[^;]*;/', '\\1', $nombre_arch);
                $file_name = preg_replace('([^A-Za-z0-9. ])', '', $nombre_arch);
                $actdocnompropio= $file_name;    
                $extension = $docum->extension();
                $file_name = md5($file_name).'.'.$extension;
                $file_route = time()."_".$file_name;     
                $size = $request->file('name_file')->getSize();          
                Storage::disk('library_files')->put($file_route, file_get_contents($docum->getRealPath() ) );
                $complet_path =Storage::disk('library_files')->url($file_route);
                Storage::delete($libraryfile->route_file);
                $libraryfile->name_file = $docum->getClientOriginalName(); 
                $libraryfile->route_file =$complet_path;  
                $libraryfile->size = $size; 
            }    
            
            $libraryfile->description = $request->description;  
            $libraryfile->type_branch_law_id = $request->branch_law;  
            $libraryfile->category_id = $request->category;  
            $libraryfile->limit_date = $request->fecha_max;
            $libraryfile->save();             
        }

        $library = Library::select('id','name_file','size','user_id','created_at')
        ->paginate(30); 
        $view = view('content.library.ajax.index',compact('library'))->render();

        return response()->json(['view'=>$view]);
           
    }

    public function destroy(Request $request)
    {

        $library =  Library::find($request['id']);
       // Storage::delete($library->route_file);             
        $library->type_status_id = 15;   
        $library->save();      
        return response()->json($request['id']);
    }

    public function downloadFile($lid){
        array_map('unlink', glob(public_path('temp/'.auth()->user()->id.'___*')));//elimina los archivos que el 
       
        $library= Library::find($lid)  ;
        if ($library) {
          $url = 'app/'.$library->route_file;
          $rutaDeArchivo = storage_path($url);
          $filename = auth()->user()->id.'___'.$library->name_file;
          copy( $rutaDeArchivo, public_path("temp/".$filename));
          return redirect("temp/".$filename); 
        }
    
    }

}
