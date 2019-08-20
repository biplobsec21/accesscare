<div class="card">
 <div class="table-responsive">
  <table class="notesTbl table-striped table-sm table" data-page-length="5">
   <thead>
    <tr>
     <th>
      <strong>#</strong>
      Notes
     </th>
    </tr>
   </thead>
   <tbody>
    <tr>
     <td data-order="2019-01-09" class="">
      <a class="mono" href="#">BHV-20180627-9BG6J9B5</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> Patient was treated 6/17/18 through 7/26/18; d/c for non-serious AE...
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2019-01-09</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr>
    @if((\Auth::user()->type->name == 'Pharmaceutical') || (\Auth::user()->type->name == 'Early Access Care'))
     <tr class="">
      <td data-order="2018-12-31" class="">
       <a class="mono" href="#">Migalastat (Galafold)</a>
       <span class="badge badge-info">Drug</span>
       <p class="mb-2 small">
        <strong>Allison Newell-Sturdivant:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, nesciunt...
       </p>
       <div class="d-flex flex-wrap justify-content-between small">
        <div>2018-12-31</div>
        <a href="#">View &raquo;</a>
       </div>
      </td>
     </tr>
    @endif
{{--     <tr>
     <td data-order="2018-12-05" class="">
      <a class="mono" href="#">AMI-20180713-CZAMVX13</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> Migalastat shipment #1 (42 capsules) have arrived in NZ at Pharmacy...
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2018-12-05</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr>
    <tr>
     <td data-order="2018-12-04" class="">
      <a class="mono" href="#">AMI-20180713-AHLWIFI3</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> Patient reported pick up of migalastat from pharmacy 4December2018.
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2018-12-04</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr>
    <tr>
     <td data-order="2018-11-09" class="">
      <a class="mono" href="#">AMI-20180713-2A0IJTZZ</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> Patient was PID 5011 in Amicus Clinical trial -042
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2018-11-09</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr>
    <tr>
     <td data-order="2018-08-27" class="">
      <a class="mono" href="#">BHV-20180720-Z50I2XNP</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> RS1_Tracking information not received from Coghlan.
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2018-08-27</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr> --}}
    <tr>
     <td data-order="2018-08-16" class="">
      <a class="mono" href="#">BHV-20180717-XWHXWS4G</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> Drug order for Resupply submitted on 8/14/18. Drug order processed...
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2018-08-16</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr>
    <tr>
     <td data-order="2018-08-09" class="">
      <a class="mono" href="#">BHV-20180627-9BG6J9B5</a>
      <span class="badge badge-light">RID</span>
      <p class="mb-2 small">
       <strong>Sarah Alummootil:</strong> Patient was discontinued 7/26 at Month 1 visit for AE of cough
      </p>
      <div class="d-flex flex-wrap justify-content-between small">
       <div class="">2018-08-09</div>
       <a href="#" class="">View &raquo;</a>
      </div><!-- /.d-flex -->
     </td>
    </tr>
    @if(\Auth::user()->type->name == 'Early Access Care')
     <tr class="">
      <td data-order="2018-05-17" class="">
       <a class="mono" href="#">Eduardo Locatelli</a>
       <span class="badge badge-secondary">User</span>
       <p class="mb-2 small">
        <strong>Anne Cropp:</strong> CV and Medical License have been uploaded through the administrative portal and are archived....
       </p>
       <div class="d-flex flex-wrap justify-content-between small">
        <div>2018-05-17</div>
        <a href="#">View &raquo;</a>
       </div>
      </td>
     </tr>
    @endif
   </tbody>
  </table>
 </div>
</div>