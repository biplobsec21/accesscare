<?php

namespace App\Http\Controllers;

use App\DocumentType;
use App\Drug;
use App\DrugDocument;
use App\File;
use App\Http\Requests\Document\CreateRequest;
use App\Resource;
use App\RidDocument;
use App\RidVisit;
use App\Traits\Filer;
use App\Traits\Notifier;
use Illuminate\Http\Request;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 * @author Andrew Mellor <andrew@quasars.com>
 */
class DocumentController extends Controller
{
    use Filer, Notifier;

    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $documents = RidDocument::all();
        return view('portal.settings.manage.document.index', ['docs' => $documents]);
    }

    /**
     * Store a newly created rid resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeRidUpload(Request $request)
    {
        $document = RidDocument::where('id', $request->input('document_id'))->firstOrFail();
        $document->desc = $request->input('desc');
        if (isset($request->upload_file)) {
            $file = $this->createFile($request->file('upload_file'), 'rid.doc');
            $document->file_id = $file->id;
        }
        $document->save();
        if ($document->visit->getDocStatus()) {
            $this->createNotice('visit_docs_submitted', $document->visit, 'eac');
            $rid = $document->visit->rid;
            if ($rid->status->name == 'New') {
                $rid->status_id = \App\RidMasterStatus::where('name', 'Pending')->firstOrFail()->id;
                $rid->save();
                return redirect()->back()->with("alerts", [['type' => 'success', 'msg' => 'File Uploaded!'], ['type' => 'success', 'msg' => 'Status Set To Pending']]);
            }
        }

        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'File Uploaded!']);
    }

    /**
     * Store a newly created rid resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeRedacted(Request $request)
    {
        $document = RidDocument::where('id', $request->input('document_id'))->firstOrFail();
        $document->desc = $request->input('desc');
        // dd($request->input('is_required'));
        if (isset($request->redacted_file)) {
            $file = $this->createFile($request->file('redacted_file'), 'rid.redacted');
            $document->redacted_file_id = $file->id;
        }

        $document->save();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Added Redacted File!']);
    }

    public function storeRidForm(Request $request)
    {
        $visit = RidVisit::where('id', "=", $request->input('visit_id'))->firstOrFail();
        $document = new RidDocument();
        $document->id = $this->newID(RidDocument::class);
        $document->type_id = $request->type_id;
        $document->visit_id = $visit->id;

        if ($request->file('template_file')) {
            $file = $this->createFile($request->file('template_file'), 'rid.template');
            $document->template_file_id = $file->id;
        }

        $document->desc = $request->input('desc');
        $document->is_required = $document->is_required_resupply = $request->input('required');
        $document->save();
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Document Added Successfully']);
    }

    public function storeDrugDoc(CreateRequest $request)
    {
        $drug = Drug::where('id', "=", $request->input('drug_id'))->firstOrFail();
        $document = new DrugDocument();
        $document->drug_id = $drug->id;

        $document->id = $this->newID(DrugDocument::class);
        $document->type_id = $request->type_id;

        if ($request->file('template_file')) {
            $file = $this->createFile($request->file('template_file'), 'drug.doc');
            $document->file_id = $file->id;
        }

        $document->desc = $request->input('desc');
        $document->is_required = $request->input('is_required') == 'on' ? 1 : 0;
        $document->is_required_resupply = $request->input('is_required_resupply') == 'on' ? 1 : 0;
        // $document->active = $request->input('active') == 'on'? 1 : 0;
        $document->save();
        $sweetAlert = 'swal({
                        title: "",
                        text: "Document Added Successfully",
                        showConfirmButton: false
                       }); setTimeout(function() { 
                          swal.close();
                      },500);';
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Document Added Successfully'])->with('sweet_alert', $sweetAlert);
    }

    public function updateRequiredRidDoc()
    {
        foreach ($_POST['doc'] as $id => $val) {
            $document = RidDocument::where('id', $id)->first();
            $document->is_required = $val;
            $document->is_required_resupply = $val;
            $document->save();
        }
        return redirect()->back();
    }

    public function storeDrugResource(CreateRequest $request)
    {

        $resource = new Resource();
        $resource->id = $this->newID(Resource::class);
        $resource->type_id = $request->input('type_id');
        $resource->name = $request->input('name');
        $resource->desc = $request->input('desc');
        $resource->active = 1;
        $resource->public = $request->input('public') == 'on' ? 1 : 0;
        $resource->file_id = 0;
        $resource->drug_id = $request->input('drug_id');

        if (isset($request->file_id)) {
            $file = $this->createFile($request->file('file_id'), 'drug.resource');
            $resource->file_id = $file->id;
        }

        $resource->save();
        $sweetAlert = 'swal({
                        title: "",
                        text: "Resource Added Successfully",
                        showConfirmButton: false
                       }); setTimeout(function() { 
                          swal.close();
                      },500);';
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Resource Added Successfully'])->with('sweet_alert', $sweetAlert);
        // return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateRidDoc(Request $request)
    {
        $document = RidDocument::where('id', "=", $request->input('document_id'))->firstOrFail();
        if ($request->input('type_id')) {
            $document->type_id = $request->input('type_id');
            $document->is_required = $request->input('is_required') == 'on' ? 1 : 0;
            $document->is_required_resupply = $request->input('is_required_resupply') == 'on' ? 1 : 0;
            $document->active = $request->input('active') == 'on' ? 1 : 0;
        }
        $document->desc = $request->input('desc');

        if (isset($request->upload_file)) {
            $file = $this->createFile($request->file('file_id'), 'rid.doc');
            $document->file_id = $file->id;
        }
        if (isset($request->redacted_file)) {
            $file = $this->createFile($request->file('redacted_file'), 'rid.redacted');
            $document->redacted_file_id = $file->id;
        }

        $document->save();

        return redirect()->back();
    }

    public function updateDrugDoc(Request $request)
    {
        $document = DrugDocument::where('id', "=", $request->input('document_id'))->firstOrFail();
        $document->type_id = $request->type_id;

        if ($request->file('template_file')) {
            $file = $this->createFile($request->file('template_file'), 'drug.doc');
            $document->file_id = $file->id;
        }

        $document->desc = $request->input('desc');
        $document->is_required = $request->input('is_required') == 'on' ? 1 : 0;
        $document->is_required_resupply = $request->input('is_required_resupply') == 'on' ? 1 : 0;
        $document->active = $request->input('active') == 'on' ? 1 : 0;
        $document->save();
        $sweetAlert = 'swal({
                        title: "",
                        text: "Document Added Successfully",
                        showConfirmButton: false
                       }); setTimeout(function() { 
                          swal.close();
                      },500);';
        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Document Updated Successfully'])->with('sweet_alert', $sweetAlert);
    }

    public function updateResource(Request $request)
    {
        $resource = Resource::where('id', "=", $request->input('document_id'))->firstOrFail();
        $resource->type_id = $request->input('type_id');
        $resource->name = $request->input('name');
        $resource->desc = $request->input('desc');
        $resource->active = $request->input('active') == 'on' ? 1 : 0;
        $resource->public = $request->input('public') == 'on' ? 1 : 0;

        if (isset($request->file_id)) {
            $file = $this->createFile($request->file('file_id'), 'drug.resource');
            $resource->file_id = $file->id;
        }

        $resource->save();

        return redirect()->back()->with("alert", ['type' => 'success', 'msg' => 'Resource Updated Successfully']);
    }

    /**
     * Unlink file from document in storage.
     * @return \Illuminate\Http\Response
     */
    public function removeFile()
    {

        $document = DrugDocument::where('id', "=", $_POST['id'])->firstOrFail();
        \Storage::delete($document->file->path . '/' . $document->file->name);
        File::where('id', $document->file_id)->delete();
        $document->file_id = NULL;
        $document->saveOrFail();
        return;
    }

    public function removeResourceFile()
    {


        $resource = Resource::where('id', "=", $_POST['id'])->firstOrFail();
        \Storage::delete($resource->file->path . '/' . $resource->file->name);
        File::where('id', $resource->file_id)->delete();
        $resource->file_id = NULL;
        $resource->saveOrFail();

        return;
    }

    public function removeTemplate()
    {
        echo $_POST['id'];

        if ($_POST['field'] == 'upload_file') {
            $file_name = 'file_id';
        }
        if ($_POST['field'] == 'redacted_file') {
            $file_name = 'redacted_file_id';
        }

        $document = RidDocument::where('id', "=", $_POST['id'])->firstOrFail();
        $document[$file_name] = 0;
        $document->saveOrFail();
        return;
    }

    public function deleteFile()
    {

        $document = DocumentType::where('id', "=", $_POST['id'])->firstOrFail();
        $document->template = NULL;
        $document->saveOrFail();
        // echo $_POST['id'];
        return;
    }

    public function removeTemplateDocument()
    {
        if ($_POST['field'] == 'upload_file') {
            $file_name = 'file_id';
        }
        if ($_POST['field'] == 'redacted_file') {
            $file_name = 'redacted_file_id';
        }

        $document = RidDocument::where('id', "=", $_POST['id'])->firstOrFail();
        $document[$file_name] = 0;
        $document->saveOrFail();
        return;
    }


    public function writeDB()
    {
        $save_data = $_POST['save_data'];

        try {
            if ($save_data['id'] === 'new') {
                $row = new RidDocument;
                $save_data['id'] = $this->generateUniqueWithPrefix('mysql', RidDocument::getTableName(), 'id', 'DOCUMENT', $this->GENERATESSTRINGS_CHARS_UPPER_LOWER_NUM, 30);
            } else {
                $row = RidDocument::where('id', "=", $save_data['id'])->firstOrFail();
            }

            foreach ($save_data as $field => $val) {
                $row->$field = $val;
            }
            $row->saveOrFail();
        } catch (\Exception $e) {
            throw $e;
        }

        return ["result" => "Success"];
    }
}
