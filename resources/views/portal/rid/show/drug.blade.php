<strong class="d-block">Drug</strong>
@if(\Auth::user()->type->name == 'Early Access Care')
<a href="{{ route('eac.portal.drug.show', $rid->drug->id) }}" class="mono">
 {{ $rid->drug->name }}
</a> ({{$rid->drug->lab_name}})
<div>
 <a href="{{ route('eac.portal.company.show', $rid->drug->company->id) }}">
  {{ $rid->drug->company->name }}
 </a>
</div>
@else
 <span class="mono">{{ $rid->drug->name }}</span> ({{$rid->drug->lab_name}})
 <div>
  {{ $rid->drug->company->name }}
 </div>
@endif