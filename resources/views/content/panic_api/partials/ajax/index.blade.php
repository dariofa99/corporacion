@foreach($panic_alerts as $key => $panic_alert)
<div class="card card-solid card-warning card-outline p-2" id="panic_alert-{{$panic_alert->id}}">
@include('content.panic_api.partials.ajax.panic_alert')
</div>
@endforeach
<div class="row">
    <div class="col-md-12">
        {{ $panic_alerts->appends(request()->query())->links() }}
    </div>
</div>
