<?php

namespace App\Http\Controllers\Settings\Manage\Website;

use Illuminate\Http\Request;
use App\Menu;
use App\Page;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Illuminate\Validation\Rule;


class WebsitePageController extends Controller {

    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.website.page.edit',
        'createButton' => 'eac.portal.settings.manage.website.page.create',
        'deleteButton' => 'eac.portal.settings.manage.website.pagedelete',
        'storeAction' => 'eac.portal.settings.manage.website.page.store',
        'updateAction' => 'eac.portal.settings.manage.website.page.update',
        'listAll' => 'eac.portal.settings.manage.website.page.index',
        'cancelAction' => 'eac.portal.settings.manage.website.page.index',
        'logsr' => 'eac.portal.settings.manage.website.page.logs',
        'logsviewr' => 'eac.portal.settings.manage.website.page.logsview',
        // blade load
        'indexView' => 'portal.settings.manage.website.page.index',
        'createView' => 'portal.settings.manage.website.page.create',
        'editView' => 'portal.settings.manage.website.page.edit',
        'ajaxView' => 'portal.settings.manage.website.page.ajaview',
        'logsv' => 'portal.settings.manage.website.page.log',
        'logsviewv' => 'portal.settings.manage.website.page.log_view',
        'detail' => 'portal.settings.manage.website.page.details',
    ];
    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }

    public function index(Request $request) {
        $rows = Page::all();
       

        return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'page')
                        ->with('rows', $rows);
    }

    public function update(Request $request, $id) {

        $validator = Validator::make(
                         $request->all(), [
                            'slug' => 'unique:pages,slug,'.$id,
                            'name' => 'required',
                        ], [
                            'name.required' => ' Name Field is Required',
                        ]
        );
        // dd($validator);
        if ($validator->fails()) {
            return redirect()->back()->with("alerts", ['type' => 'danger', 'msg' => 'Error occured in the page!'])
                            ->with("errors", $validator->errors())
                            ->withInput()
                            ->with('page', $this->_data);
        } else {
            $rows = Page::find($id);
            // $rows->drug_id = $request->drug_id;
            // $rows->route_id = $request->route_id;
	        $rows->name = $request->input('name');
	        $rows->title = $request->input('title');
	        $rows->menu_id = $request->input('menu_id');
	        $rows->slug = $request->input('slug');
	        $rows->content = $request->input('content');
	        $rows->meta_desc = $request->input('meta_desc');
	        $rows->meta_keywords = $request->input('meta_keywords');
            // $rows->modified_by = \Auth::user()->id;
            // $rows->created_by = \Auth::user()->id;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;

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
                    'slug' => 'required|unique:pages',
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

            $rows = new Page();
            $rows->id = $this->newID(Page::class);
            // $rows->drug_id = $request->drug_id;
            // $rows->route_id = $request->route_id;
            $rows->name = $request->input('name');
            $rows->title = $request->input('title');
            $rows->menu_id = $request->input('menu_id');
            $rows->slug = $request->input('slug');
            $rows->content = $request->input('content');
            $rows->meta_desc = $request->input('meta_desc');
            $rows->meta_keywords = $request->input('meta_keywords');
            // $rows->modified_by = \Auth::user()->id;
            $rows->active = ($request->input('active') == 'on') ? 1 : 0;
            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alerts", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }
    }
    public function create(Request $request) {
        $menu = new Menu();
        $menu_data = $menu->multiLabelMenu();

        return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('menu_data',$menu_data)
                        ->with('page', $this->_data);
    }

    public function ajaxlist() {

        $sql = Page::Where('pages.id', '!=', '')
            ->leftJoin('menus','menus.id','=','pages.menu_id')
            ->groupBy('pages.name')
            ->select([
            'pages.id as id',
            'pages.created_at as created_at',
            'pages.updated_at as updated_at',
            'pages.name as name',

            'menus.name as menu_name',
            'menus.id as menu_id',
            'pages.title as title',
            'pages.active as active'
        ]);

        return \DataTables::of($sql)
                // ->addColumn('drug', function ($row) {
                //     return $row->drug_name;
                // })
                ->setRowClass(function ($row) {
               
                if ($row->active == '1') {
                 $class = 'v-active';
                } else {

                   $class='v-inactive';

                }
                return $class;

                })
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                // ->addColumn('route', function ($row) {
                //     return $row->route;
                // })
                ->addColumn('menu_name', function ($row) {

                    return $this->has_parent_menu($row);
                    // return $row->menu_name;
                })
                ->addColumn('title', function ($row) {
                    return $row->title;
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
                        <a title="Edit Page" href="' . route('eac.portal.settings.manage.website.page.edit', $row->id) . '">
                     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Page</span>
                    </a>

                     <a title="View Details" href="'.route('eac.portal.settings.manage.website.page.detail',$row->id).'" class="veiw_details" data-id="'.$row->id.'">
                        <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View Details</span>
                    </a>
                ';
                })
                ->rawColumns([
                    'name',
                    'title',
                    'menu_name',
                    'active',
                    'created_at',
                    'ops_btns'
                ])
                
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('pages.name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('title', function ($query, $keyword) {
                    $query->where('pages.title', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('menu_name', function ($query, $keyword) {
                    $query->where('menus.name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('pages.updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name'=>0,
                        'title'=>1,
                        'menu_name'=>2,
                        'active'=>3,
                        'created_at'=>4,
                        'ops_btns'=>5,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('pages.name', $direction);
                    }
                    if (request('order.0.column') == $columns['title']) {
                        $query->orderBy('pages.title', $direction);
                    }
                    if (request('order.0.column') == $columns['menu_name']) {
                        $query->orderBy('menus.name', $direction);
                    }
                     if (request('order.0.column') == $columns['active']) {
                        $query->orderBy('pages.active', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('pages.updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }

    public function edit($id) {

        $menu = new Menu();
        $menu_data = $menu->multiLabelMenu();


        $rows = Page::where('id', '=', $id)->first();
        // dd($rows);
        if (!$rows) {
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
            $logData = $this->getLogs(Page::class);
            return view($this->_data['logsv'], [
            'logData' => $logData,
            'page'=> $this->_data,
            'wbinstance' => new WebsitePageController
        ]);
        }
    public function logsview(Request $request,$id){
            $logData = \App\Log::where('subject_id','=',$id);
            return view($this->_data['logsviewv'], [
            'logData' => $logData,
            'page'=> $this->_data,
            'wbinstance' => new WebsitePageController
        ]);
    }
    public function detail(Request $request,$id){
        $rows = Page::where('id','=',$id)->first();
            return view($this->_data['detail'], [
            'rows' => $rows,
            'page'=> $this->_data
        ]);
    }
    public  function has_parent_menu($row){
        $string="";
        $menu_id = $row->menu_id;

        // find parent menu
        $parent_id=Menu::where('id',$row->menu_id)->first();

        if($parent_id){
            
            $parent_menu_id=Menu::where('id',$parent_id->parent_menu)->first();
            if($parent_menu_id){
                 $string .= $parent_menu_id->name;
                 $string .= ' <i class="fas fa-arrow-right"></i> '.$parent_id->name;
            }else{
                 $string .= $parent_id->name;
            }
        }else{
            return '';
        }

        return $string;

        // find sub menue

    }

}
