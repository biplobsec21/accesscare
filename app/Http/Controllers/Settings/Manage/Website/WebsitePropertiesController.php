<?php

namespace App\Http\Controllers\Settings\Manage\Website;

use Illuminate\Http\Request;
use App\Menu;
use App\Page;
use App\State;
use App\WebsiteProperties;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use File;


class WebsitePropertiesController extends Controller {

    public $_data = [
        // route load
        'editButton' => 'eac.portal.settings.manage.website.properties.edit',
        'createButton' => 'eac.portal.settings.manage.website.properties.create',
        // 'deleteButton' => 'eac.portal.settings.manage.website.propertiesdelete',
        'storeAction' => 'eac.portal.settings.manage.website.properties.store',
        // 'updateAction' => 'eac.portal.settings.manage.website.properties.update',
        'listAll' => 'eac.portal.settings.manage.website.properties.index',
        'cancelAction' => 'eac.portal.settings.manage.website.properties.index',
        'logsr' => 'eac.portal.settings.manage.website.properties.logs',
        'detail' => 'eac.portal.settings.manage.website.properties.show',
        // 'logsviewr' => 'eac.portal.settings.manage.website.properties.logsview',
        // // blade load
        'indexView' => 'portal.settings.manage.website.properties.index',
        'createView' => 'portal.settings.manage.website.properties.create',
        'detailView' => 'portal.settings.manage.website.properties.details',

        'editView' => 'portal.settings.manage.website.properties.edit',
        // 'ajaxView' => 'portal.settings.manage.website.properties.ajaview',
        // 'logsv' => 'portal.settings.manage.website.properties.log',
        // 'logsviewv' => 'portal.settings.manage.website.properties.log_view',
    ];
    public function __construct(){
//     $this->middleware('auth'); // auth check from the route
    }
    public function index() {
        $rows = WebsiteProperties::all();
         $rows_count = WebsiteProperties::all()->count();

        // dd($rows);
       return view($this->_data['indexView'])
                        ->with('page', $this->_data)
                        ->with('active', 'menu')
                        ->with('rows', $rows)
                        ->with('rows_count', $rows_count);
    }
    public function propAjaxlist(){
            $sql = WebsiteProperties::where('id','!=','');

        return \DataTables::of($sql)
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('city', function ($row) {

                    return $row->city;
                })
                ->addColumn('phone1', function ($row) {
                    return $row->phone1;
                })

                ->addColumn('logo', function ($row) {
                    // $dir = public_path();
                    // $new_dir=str_replace("public", "public_html", $dir)."".$row->logo;
                    $new_dir = URL($row->logo);
                    return $row->logo != '' ? '<img class="propsLogo" src="'.$new_dir.'">' : '<span class="badge badge-danger">
                N/A
                </span>';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->updated_at->format(config('eac.date_format'));
                })
                ->addColumn('ops_btns', function ($row) {
                return '                        
                        <a title="Edit Properties" href="' . route('eac.portal.settings.manage.website.properties.edit', $row->id) . '">
                     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Properties</span>
                    </a>

                     <a title="View Details" href="'.route('eac.portal.settings.manage.website.properties.show',$row->id).'" class="veiw_details" data-id="'.$row->id.'">
                        <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View Details</span>
                    </a>
                ';
                })
                ->rawColumns([
                    'name',
                    'city',
                    'phone1',
                    'logo',
                    'created_at',
                    'ops_btns'
                ])

                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('city', function ($query, $keyword) {
                    $query->where('city', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('phone1', function ($query, $keyword) {
                    $query->where('phone1', 'like', "%" . $keyword . "%");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->where('updated_at', 'like', "%" . $keyword . "%");
                })
                ->order(function ($query) {
                    $columns = [
                        'name'=>0,
                        'city'=>1,
                        'phone1'=>2,
                        'created_at'=>4,
                    ];

                    $direction = request('order.0.dir');

                    if (request('order.0.column') == $columns['name']) {
                        $query->orderBy('name', $direction)->orderBy('name', $direction);
                    }
                    if (request('order.0.column') == $columns['city']) {
                        $query->orderBy('city', $direction)->orderBy('city', $direction);
                    }
                    if (request('order.0.column') == $columns['phone1']) {
                        $query->orderBy('phone1', $direction)->orderBy('phone1', $direction);
                    }

                    if (request('order.0.column') == $columns['created_at']) {
                        $query->orderBy('updated_at', $direction);
                    }
                })
                ->smart(0)
                ->toJson();
    }
    public function create(Request $request) {
        $rows_count = WebsiteProperties::all()->count();
        if($rows_count == 0){
            $state = State::where('active', '!=', '');

            return view($this->_data['createView'])
                        ->with('active', 'create')
                        ->with('page', $this->_data)
                        ->with('state', $state);
        }else{
            return redirect()->back();
        }



    }

    public function store(Request $request){
        // dd($_POST);

        $request->validate([
               'company_name' => 'required',
               'company_est' => 'required',
               'company_addr_1' => 'required',
               'company_city' => 'required',
               'company_state' => 'required',
               'company_zip' => 'required',
               'company_phone_1' => 'required',
               'company_email' => 'required',
               'company_url' => 'required',

            ],
            [
        'company_name.required' => 'Name is required',
        'company_est.required' => 'Establishedment is required',
        'company_addr_1.required' => 'Address is required',
        'company_city.required' => 'City is required',
        'company_state.required' => 'State is required',
        'company_zip.required' => 'Postal Code is required',
        'company_phone_1.required' => 'Phone is required',
        'company_email.required' => 'Email is required',
        'company_url.required' => 'Company URL is required',
    ]);

        // dd($request);
            $rows = new WebsiteProperties();
            $rows->id = $this->newID(Page::class);
            $rows->name = $request->company_name;
            $rows->establishment = $request->company_est;
            $rows->addr1 = $request->company_addr_1;
            $rows->addr2 = $request->company_addr_2;
            $rows->city = $request->company_city;
            $rows->state = $request->company_state;
            $rows->zip = $request->company_zip;
            $rows->phone1 = $request->company_phone_1;
            $rows->phone2 = $request->company_phone_2;
            $rows->email = $request->company_email;
            $rows->website = $request->company_url;

            if ($request->file('company_logo')) {
            $requestFile = $request->file('company_logo');

            // $asd = public_path();
            // dd(strrpos( $asd, "'\'"));
            // $asd = substr($asd, 0, strrpos( $asd, '/'));
            // $asd = public_path('/logo');
            $dir = public_path();
            $new_dir=str_replace("public", "public_html", $dir)."/images/";

            $filename = 'logo_' . rand(10000000, 99999999) . '.' . $requestFile->getClientOriginalExtension();
            $path = $requestFile->move($new_dir, $filename);
            // $path = $requestFile->move($dir, $filename);
            $savepath =$path;
            $rows->logo = "/images/".$filename;

            }
            else{
                $rows->logo = '';
            }
            $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data inserted successfully']);
        }

        public function detail($id){
            $rows = WebsiteProperties::where('id', '=', $id)->first();
            $state = State::where('active', '!=', '');

        return view($this->_data['detailView'])
                        ->with('active', 'create')
                        ->with('page', $this->_data)
                        ->with('rows', $rows)
                         ->with('state', $state);

        }
        public function edit($id){
            $state = State::where('active', '!=', '');
            $rows = WebsiteProperties::where('id', '=', $id)->first();

        return view($this->_data['editView'])
                        ->with('active', 'create')
                        ->with('page', $this->_data)
                        ->with('rows', $rows)
                        ->with('state', $state);
        }

        public function update(Request $request){

            $id = $request->company_id;
                 $request->validate([
               'company_name' => 'required',
               'company_est' => 'required',
               'company_addr_1' => 'required',

               'company_city' => 'required',
               'company_state' => 'required',
               'company_zip' => 'required',
               'company_phone_1' => 'required',

               'company_email' => 'required',
               'company_url' => 'required',

            ],
            [
        'company_name.required' => 'Name is required',
        'company_est.required' => 'Establishedment is required',
        'company_addr_1.required' => 'Address is required',

        'company_city.required' => 'City is required',
        'company_state.required' => 'State is required',
        'company_zip.required' => 'Postal Code is required',
        'company_phone_1.required' => 'Phone is required',

        'company_email.required' => 'Email is required',
        'company_url.required' => 'Company URL is required',
    ]);

        // dd($request);
            $rows = WebsiteProperties::find($id);
            $rows->name = $request->company_name;
            $rows->establishment = $request->company_est;
            $rows->addr1 = $request->company_addr_1;
            $rows->addr2 = $request->company_addr_2;
            $rows->city = $request->company_city;
            $rows->state = $request->company_state;
            $rows->zip = $request->company_zip;
            $rows->phone1 = $request->company_phone_1;
            $rows->phone2 = $request->company_phone_2;
            $rows->email = $request->company_email;
            $rows->website = $request->company_url;

            if ($request->file('company_logo')) {
                $requestFile = $request->file('company_logo');

            $dir = public_path();
            $new_dir=str_replace("public", "public_html", $dir)."/images/";

            $filename = 'logo_' . rand(10000000, 99999999) . '.' . $requestFile->getClientOriginalExtension();
            $path = $requestFile->move($new_dir, $filename);
            // $path = $requestFile->move($dir, $filename);
            $savepath =$path;
            $rows->logo = "/images/".$filename;
            }
            else{
                $rows->logo = $rows->logo;
            }

             $rows->save();
            return redirect(route($this->_data['listAll']))
                            ->with("alert", ['type' => 'success', 'msg' => 'Data Updated successfully']);

        }

        public function logoDelete(Request $request){

             $id = $request->id;
            $resourceData = WebsiteProperties::find($id);
            $filename = $resourceData->logo;
            $dir = public_path();
            $new_dir=str_replace("public", "public_html", $dir).$filename;
            File::delete($new_dir);
            $resourceData->logo=NULL;
            // $resourceData->save();
            $resourceData->saveOrFail();

            return ;




        }

}
