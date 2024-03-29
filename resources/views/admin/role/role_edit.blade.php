@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('public/dist/plugins/Responsive-2.2.5/css/responsive.dataTables.css') }}">
@endsection

@section('content')
<!-- Main content -->
  <div class="col-sm-12" id="roleEdit-settings-container">
    <div class="row">
      <div class="col-sm-3">
       @include('layouts.includes.company_menu')
      </div>
      <div class="col-sm-9">
        <div class="card card-info">
          <div class="card-header">
            <h5> <a href="{{ url('company/setting') }}">{{ __('Company Settings')  }} </a> >> {{ __('Edit User Role') }}</h5>
            <div class="card-header-right">
              
            </div>
          </div>
          <div class="card-body">
            <form action="{{ url('role/update') }}" method="post" id="addRole" class="form-horizontal">
              <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
              <input type="hidden" value="{{$role->id}}" name="id" id="id">
              <div class="form-group row p-t-5">
                <label class="col-sm-3 control-label name_styles" for="inputEmail3">
                  {{ __('Name')  }}
                  <span class="text-danger"> *</span>
                </label>
                <div class="col-sm-6">
                  <input type="text" name="name" placeholder="Name" id="name" class="form-control" value="{{$role->name}}">
                  <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 control-label name_styles"  for="inputEmail3">
                  {{ __('Display Name')  }}
                  <span class="text-danger"> *</span>
                </label>
                <div class="col-sm-6">
                  <input type="text" name="display_name" placeholder="Display Name" id="display_name" class="form-control" value="{{$role->display_name}}">
                  <span class="text-danger">{{ $errors->first('display_name') }}</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 control-label name_styles" for="inputEmail3">
                  {{ __('Description') }}
                  <span class="text-danger"> *</span>
                </label>
                <div class="col-sm-6">
                  <input type="text" name="description" placeholder="Description" id="description" class="form-control" value="{{$role->description}}">
                  <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 control-label control_label_styles" for="inputEmail3">
                  {{ __('Permissions') }}
                  <span class="text-danger"> *</span>
                </label>
                <div class="col-md-12">
                  <table id="dataTableBuilder" id="dataTableBuilder" class="table table-responsive table-bordered table-hover table-striped dt-responsive user-roles" width='100%' cellspacing='0'>
                    <thead>
                      <tr>
                        <th class="align-left">{{ __('Permission')  }}</th>
                        <th class="align-left">{{ __('View') }}</th>
                        
                        <th class="align-left">{{ __('Add') }}</th>
                        <th class="align-left">{{ __('Edit') }}</th>
                        <th class="align-left">{{ __('Delete') }}</th>
                        <th class="role_edit_own_view">{{ __('Own View') }}</th>
                      </tr>
                    </thead>
                    <tbody id = "manage-roles">
                      @php
                        $actions = [
                            'manage' => 'view',
                            'own' => 'own_view',
                            'add' => 'add_view',
                            'edit' => 'edit_view',
                            'delete' => 'delete_view'
                        ];
                      @endphp
                      @foreach($permissions as $key=>$row) 

                        <tr>
                          <td class="roles">
                              {{ $key }}
                          </td>
                           
                              @for ($i = 0; $i < 5; $i++)
                              <td>
                                @php
                                  $per = explode("_", $row[$i]['name']);
                                  if (array_key_exists($per[0], $actions)) :
                                  $action = $actions[$per[0]];
                                  $name = str_replace(' ', '', $key);
                                @endphp
                                
                                <div class="checkbox checkbox-success d-inline-block permissions">
                                  <input type="checkbox" class="view-check" name="permissions[]" value="{{ $row[$i]['id'] }}" id="{{ $action }}_{{ $name }}" key="{{ $name }}" status="{{ $action }}" {{ in_array($row[$i]['id'], $stored_permissions) ? 'checked' : '' }}>
                                  <label for="{{ $action }}_{{ $name }}" class="cr margin_bottom"></label>
                                </div>
                                <?php endif; ?>
                              </td>
                            @endfor
                        </tr>                            
                      @endforeach  
                    </tbody>
                  </table>
                </div>
              </div>
              <span class="errors f-12"></span>
              <div class="p-0">
                <a href="{{ url('role/list') }}" class="btn btn-danger custom-btn-small">{{ __('Cancel')  }}</a>
                <button class="btn btn-primary custom-btn-small float-left" type="submit">{{ __('Submit')  }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

@include('layouts.includes.message_boxes')
@endsection

@section('js')
  <script src="{{ asset('public/dist/plugins/DataTables-1.10.21/js/jquery.dataTablesCus.min.js') }}"></script>
  <script src="{{ asset('public/dist/plugins/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>

  <script src="{{ asset('public/dist/js/jquery.validate.min.js') }}"></script>
  {!! translateValidationMessages() !!}
  <script src="{{ asset('public/dist/js/custom/settings.min.js') }}"></script>
@endsection