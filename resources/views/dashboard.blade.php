@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach (['danger', 'warning', 'success', 'info'] as $key)
                @if(Session::has($key))
                    <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                @endif
            @endforeach
            <div class="card">
                <form class="upload-form" method="POST" action="{{ route('storeExcelFile') }}" enctype="multipart/form-data" autocomplete="off">
                     {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                            <label for="file">File<span class="required-field">*</span></label>
                            <input class="upload-file form-control-file" type="file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel" data-size="" required>
                            @if ($errors->has('file'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('file') }}</strong>
                              </span>
                            @endif
                        </div>
                         <div class="clearfix">
                          <div class="pull-right">
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                </form>
            </div>
            <div class="card">
                    <h4>Fetch data from last file</h4>
                    <div class="fetch-button">
                        <button type="submit" class="btn btn-primary fetch_data">Fetch</button>
                    </div>
                    <div class="search_div" style="display:none">
                        <form method="GET">
                            <input type="text" name="search_key" value="" class="search_key input_space" placeholder="Table header e.g Name">
                            <input type="text" name="search_value" value="" class="search_value input_space" placeholder="e.g john">
                            <button type="submit" class="btn btn-primary btn-sm search input_space">Search</button>
                            <a href="" class="reset_all">Reset all</a>
                        </form>
                    </div>

                <div class="table-responsive">
                    <table id="table" class="table_list table table-bordered">

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
