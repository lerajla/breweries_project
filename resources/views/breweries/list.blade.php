@extends('layouts.app')

@section('content')

<div class="row align-items-center vh-100 text-center">
    <div id="col_breweries-table" class="col-12">
      @include('breweries.table')
    </div>
</div>
@endsection

@section('pageScripts')
<script src="{{ asset('js/breweries-manager.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  const routeGetBreweriesList = '{{ route('breweries.list') }}';

  $(document).ready(function() {
    breweriesManager.init();
  });
</script>
@endsection
