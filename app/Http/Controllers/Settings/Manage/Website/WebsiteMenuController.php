<?php

namespace App\Http\Controllers\Settings\Manage\Website;

use Illuminate\Http\Request;
use App\Menu;
use App\Page;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use File;


class WebsiteMenuController extends Controller {

    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.website.menu.edit',
        'createButton' => 'eac.portal.settings.manage.website.menu.create',
        'deleteButton' => 'eac.portal.settings.manage.website.menudelete',
        'storeAction' => 'eac.portal.settings.manage.website.menu.store',
        'updateAction' => 'eac.portal.settings.manage.website.menu.update',
        'listAll' => 'eac.portal.settings.manage.website.menu.index',
        'cancelAction' => 'eac.portal.settings.manage.website.menu.index',
        'logsr' => 'eac.portal.settings.manage.website.menu.logs',
        'logsviewr' => 'eac.portal.settings.manage.website.menu.logsview',
        // blade load
        'indexView' => 'portal.settings.manage.website.menu.index',
        'createView' => 'portal.settings.manage.website.menu.create',
        'editView' => 'portal.settings.manage.website.menu.edit',
        'ajaxView' => 'portal.settings.manage.website.menu.ajaview',
        'logsv' => 'portal.settings.manage.website.menu.log',
        'logsviewv' => 'portal.settings.manage.website.menu.log_view',
    ];
    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index(Request $request) {
        $rows = Menu::all();

        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'menu')
                        ->with('rows', $rows);
    }
    public function update(Request $request, $id) {
        $validator = Validator::make(
                        $request->all(), [
                    // 'name' => 'required|unique:menus,name,'.$id,
                    'name' => 'required',
                    'slug' => 'required|unique:menus,slug,'.$id,
                        ], [
                    'name.required' => ' Name Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {
            $rows = Menu::find($id);
            // $rows->drug_id = $request->drug_id;
            // $rows->route_id = $request->route_id;
            $rows->name = $request->name;
            $rows->route = $request->route;
            $rows->parent_menu = $request->parent_menu;
            $rows->sequence = $request->sequence;
            $rows->slug = $request->slug;
            // $rows->created_by = \Auth::user()->id;
            $rows->modified_by = \Auth::user()->id;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;

             $menuSlug = Menu::where('id','=',$request->parent_menu)->first()->slug;
            if($menuSlug == 'root'){

                $folder = $this->clean($request->slug);
                $path = resource_path( 'views/public/pages/'.$folder.'');
                if(!File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                // create default index.blade.php
                $path = $path.'/index.blade.php';
                if(!File::exists($path)) {
                    fopen( $path, 'w' );
                    if(File::put($path, $this->template())) {
                        //dd('wwrite successfulls');
                    }
                }
                $rows->file_name = $folder.'.index';
            }else{

                $menuSlug = Menu::where('id','=',$request->parent_menu)->first()->slug;
                $folder = $this->clean($menuSlug);
                $fileName = $this->clean($request->slug);
                
                $semifilter = str_replace($folder,'',$fileName);
                $path = resource_path( 'views/public/pages/'.$folder.'/'.$semifilter.'.blade.php' );

                if(!File::exists($path)) {
                 // dd(resource_path());
                    fopen( $path, 'w' );
                    if(File::put($path, $this->template())) {
                        //dd('wwrite successfulls');
                    }
                }

                $rows->file_name = $folder.'.'.$semifilter;

            }

            if ($rows->isDirty()) {
                $rows->save();
                return redirect()->back()
                                ->with("alerts", ['type' => 'success', 'msg' => 'Data Updated successfully']);
            }

            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alerts", ['type' => 'success', 'msg' => 'Data Updated successfully']);
        }
    }

    public function store(Request $request) {

        $currentTimestamp = date('Y-m-d H:i:s');
        $validator = Validator::make(
                        $request->all(), [
                    // 'drug_id' => 'required',
                    // 'route_id' => 'required',
                    'slug' => 'required|unique:menus',
                    'name' => 'required',

                        ], [
                    'name.required' => ' Name Field is Required',
                        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {

            $rows = new Menu();
            $rows->id = $this->newID(Menu::class);
            $rows->name = $request->name;
            $rows->route = $request->route;
            $rows->slug = $request->slug;
            $rows->parent_menu = $request->parent_menu;
            $rows->sequence = $request->sequence;
            $rows->created_by = \Auth::user()->id;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;
            // check parent menu is not the root menu then write file//
            
            // find out request parent menu is root or not //
            $menuSlug = Menu::where('id','=',$request->parent_menu)->first()->slug;
            // dd($menuName);
            if($menuSlug == 'root'){

                $folder = $this->clean($request->slug);
                $path = resource_path( 'views/public/pages/'.$folder.'');
                if(!File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                // create default index.blade.php
                $path = $path.'/index.blade.php';
                if(!File::exists($path)) {
                 // dd(resource_path());
                    fopen( $path, 'w' );
                    if(File::put($path, $this->template())) {
                        //dd('wwrite successfulls');
                    }
                }
                $rows->file_name = $folder.'.index';
                
            }else{

                $menuSlug = Menu::where('id','=',$request->parent_menu)->first()->slug;
                $folder = $this->clean($menuSlug);
                $fileName = $this->clean($request->slug);
                
                $semifilter = str_replace($folder,'',$fileName);
                $path = resource_path( 'views/public/pages/'.$folder.'/'.$semifilter.'.blade.php' );

                if(!File::exists($path)) {
                 // dd(resource_path());
                    fopen( $path, 'w' );
                    if(File::put($path, $this->template())) {
                        //dd('wwrite successfulls');
                    }
                }
                $rows->file_name = $folder.'.'.$semifilter;
            }
            // dd('here');
          
            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }
    }
    public function create(Request $request) {
        $menu = new Menu();
        $menu_data = $menu->multiLabelMenu();
        // dd($menu_data);
        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('menu_data',$menu_data)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = Menu::where('slug','!=','root')->where('parent_menu','=','001aefrgth')->orderBy('sequence','asc')
                ->select([
            'id',
            'created_at',
            'updated_at',
            'name',
            'route',
            'parent_menu',
            'sequence',
            'active'

        ]);

        return \DataTables::of($sql)
                // ->addColumn('drug', function ($row) {
                //     return $row->drug_name;
                // })
                
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                // ->addColumn('route', function ($row) {
                //     return $row->route;
                // })
                ->addColumn('sub_menu', function ($row) {
                    
                    return $this->sub_menu_data($row->id);
                })
                ->addColumn('sequence', function ($row) {
                    return $row->sequence;
                })
               
                ->addColumn('active', function ($row) {
                    return $row->active == '1' ? '<span class="badge badge-success">Active
                </span>' : '<span class="badge badge-danger">
                Inactive
                </span>';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->updated_at->format(config('eac.date_format'));
                })
                ->addColumn('ops_btns', function ($row) {
                    return '

                <a title="Edit Menu" href="' . route('eac.portal.settings.manage.website.menu.edit', $row->id) . '">
                 <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Menu</span>
                </a>
                ';
                })
                ->rawColumns([
                    'name',
                    // 'route',
                    'sub_menu',
                    'sequence',
                    'active',
                    'created_at',
                    'ops_btns'
                ])
                
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })
                // ->filterColumn('route', function ($query, $keyword) {
                //     $query->where('route', 'like', "%" . $keyword . "%");
                // })
                // ->filterColumn('sub_menu', function ($query, $keyword) {
                //     $query->where('parent_menu', 'like', "%" . $keyword . "%");
                // })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name'=>0,
                        // 'route'=>1,
                        'sub_menu'=>1,
                        'sequence'=>2,
                        'created_at'=>3,
                        'active'=>4,
                        'ops_btns'=>5,
                    ];

                    $direction = request('order.0.dir');

                    // if (request('order.0.column') == $columns['drug']) {
                    //     $query->orderBy('drug.name', $direction)->orderBy('drug.name', $direction);
                    // }

                    // if (request('order.0.column') == $columns['created_at']) {
                    //     $query->orderBy('dosage.created_at', $direction);
                    // }
                })
                ->smart(0)
                ->toJson();
    }

    public function edit($id) {

        $menu = new Menu();
        $menu_data = $menu->multiLabelMenu();

        $rows = Menu::where('id', '=', $id);
        if (!count($rows)) {
            return redirect(route($this->_data['listAll']));
        }

        return view($this->_data['editView'])
                        ->with('active', 'edit')
                        ->with('menu_data',$menu_data)
                        ->with('rows', $rows)
                        ->with('page', $this->_data);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $resourceData = Menu::find($id);
        if ($resourceData):
            if ($resourceData->delete()):
                return [
                    'result' => 'success'
                ];
            endif;
        endif;
    }
    public function logs(){
            $logData = $this->getLogs(Menu::class);
            return view($this->_data['logsv'], [
            'logData' => $logData,
            'page'=> $this->_data
        ]);
    }
    public function logsview(Request $request,$id){
            $logData = \App\Log::where('subject_id','=',$id);
            return view($this->_data['logsviewv'], [
            'logData' => $logData,
            'page'=> $this->_data
        ]);
    }
    public function sub_menu_data($id){

        $string =" ";
        $data = Menu::where('parent_menu','=',$id)->orderBy('sequence','asc');
        if($data->count() > 0){
            foreach($data as $val){
                $string .= 
                '<a href="'. route('eac.portal.settings.manage.website.menu.edit', $val->id).'" class="badge badge-warning m-1">
                               '.$val->name.'
                </a>';
            }
        }else{
            return "No Sub Menu Found";
        }

        return $string;
    }
    protected function template(){
        return  '@extends("layouts.public")

@section("styles")
@endsection


@section("content")


<div class="section">
 <div class="container">
  @php
  // can access content via menu id also
  // $pageContent = App\Page::where("menu_id","=",$menu_id);
  @endphp

{{-- Content will be shown as per sequence number of the page --}}
 @if($pagesContent->count() > 0)
  @foreach($pagesContent as $val)
   @section("title")
   {{ $val->title }}
   @endsection
   {!! $val->content !!}
  @endforeach
  @else 
   <div class="alert alert-light">
    <h3>Content not found for <em>{{$menuname}}</h3>
    <p>Please create content</p>
   </div>
  @endif

 </div>
</div>


@endsection

@section("scripts")
@endsection
        ';
    }
  
    public function clean($string) {

        $filter = str_replace('-root',' ',$string);
        $filter = str_replace('-',' ',$filter);
        $string =  strtolower(preg_replace('/\s+/','',$filter));
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}