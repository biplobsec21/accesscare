<div class="modal fade" id="newDocumentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <form method="post" action="{{ route('eac.portal.rid.document.additional.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="visit_id" value="{{$visit->id}}"/>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h4 class="m-0">
                        New Form </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-lg mb-3">
                            <label class="d-block label_required">Form Type</label>
                            <select class="form-control" name="type_id" required="required">
                                <option disabled hidden selected value="">-- Select --</option>
                                @foreach(\App\DocumentType::all()->sortBy('name') as $type)
                                    <option value="{{$type->id}}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-auto mb-3">
                            <label class="d-block">Requirement</label>
                            <input type="hidden" name="required" value="0"/>
                            <input data-field="required" type="checkbox" value="1" data-toggle="toggle" data-off="Periodic" data-on="Required" data-onstyle="success" data-offstyle="light" name="required" checked data-width="120"/>
                        </div>
                    </div>
                    <div class="mb-3" id="upload_file_ajax">
                        <label class="d-block">Template
                            <small>({{config('eac.storage.file.type')}})</small>
                        </label>
                        <div class="input-group m-0">
                            <input class="form-control" type="file" name="template_file"/>
                        </div>
                        <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
                    </div>
                    <div class="">
                        <label class="d-block">Additional Information</label>
                        <textarea class="form-control" rows="5" name="desc"></textarea>
                    </div>
                </div>
                <div class="modal-footer p-2 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
