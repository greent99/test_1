@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css"  href="{{asset('asset_admin/css/custom/product-order-custom.css')}}" />
@endsection


@section('page-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{\Illuminate\Support\Facades\Lang::get('en.pt_language')}}</h4>


            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- start table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row search-row-custom">
                        <div class="col-sm-2 text-left ">
                            <div class="form-group">
                                <label class="control-label">Unit</label>
                                <select class="form-control select2">
                                    <option value="0" disabled selected>Select</option>
                                    <option value="AK">Alaska</option>
                                    <option value="HI">Hawaii</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 text-left ">
                            <div class="form-group">
                                <label class="control-label">Unit</label>
                                <select class="form-control select2">
                                    <option value="0" disabled selected>Select</option>
                                    <option value="AK">Alaska</option>
                                    <option value="HI">Hawaii</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 text-left ">
                            <div class="form-group">
                                <label class="control-label">Unit</label>
                                <select class="form-control select2">
                                    <option value="0" disabled selected>Select</option>
                                    <option value="AK">Alaska</option>
                                    <option value="HI">Hawaii</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 search-col-custom" >
                            <div class="search-box search-group-custom">
                                <input type="text" class="form-control " placeholder="Search...">
                                <a href="#" class="btn btn-primary btn-rounded">Search</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row items-custom">
                        <div class="left-items-custom">
                            <a href="#" class="btn btn-danger btn-rounded waves-effect waves-light mb-2 mr-2">Delete</a>
                            <a data-url="{{route('renderexport_language')}}" data-type="excel" data-flag="1" onclick="exportExcel(this)" class="btn btn-danger btn-rounded waves-effect waves-light mb-2 mr-2">Export Excel</a>
                            <a data-url="{{route('renderexport_language')}}" data-type="pdf" onclick="exportPdf()"  class="btn btn-danger btn-rounded waves-effect waves-light mb-2 mr-2">Export Pdf</a>
                        </div>
                        <div class="right-items-custom">
                            <a  href="{{route('add_language')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> Add Quick</a>
                        </div>
                    </div>
                    <!-- end filter-->

                    <div class="table-responsive-sm">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                            <tr>
                                <th class="checkbox-custom">
                                    <div class="custom-control custom-checkbox">
                                        <input id="check_all" name="allCheckbox" type="checkbox" class="custom-control-input" onchange="checkAll()">
                                        <label class="custom-control-label" for="check_all">&nbsp;</label>
                                    </div>
                                </th>
                                <th class="order-id-custom">
                                    <input type="checkbox" id="check_id" name="checkExport" data-attr="id" hidden>
                                    <label for="check_id"></label>
                                    {{\Illuminate\Support\Facades\Lang::get('en.tb_id')}}
                                </th>
                                <th class="name-custom">
                                    <input type="checkbox" id="check_name" name="checkExport" data-attr="name" hidden>
                                    <label for="check_name"></label>
                                    {{\Illuminate\Support\Facades\Lang::get('en.tb_name')}}</th>
                                <th class="icon-custom text-center">
                                    <input type="checkbox" id="check_icon" name="checkExport" data-attr="icon" hidden>
                                    <label for="check_icon"></label>
                                    {{\Illuminate\Support\Facades\Lang::get('en.pt_icon')}}</th>
                                <th class="image-custom ">
                                    <input type="checkbox" id="check_image" name="checkExport" data-attr="image" hidden>
                                    <label for="check_image"></label>
                                    {{\Illuminate\Support\Facades\Lang::get('en.pt_image')}}</th>
                                <th class="url-custom text-center">
                                    <input type="checkbox" id="check_url" name="checkExport" data-attr="url" hidden>
                                    <label for="check_url"></label>
                                    {{\Illuminate\Support\Facades\Lang::get('en.pt_url')}}
                                </th>
                                <th>
                                    <p hidden>magic frontend</p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $language)
                            <tr id="row_{{$language->id}}">
                                <td class="checkbox-custom">
                                    <div class="custom-control custom-checkbox">
                                        <input value="{{$language->id}}" type="checkbox" name="checkbox" class="custom-control-input" id="check_{{$language->id}}">
                                        <label class="custom-control-label" for="check_{{$language->id}}">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="order-id-custom"><a  class="text-body font-weight-bold">{{$language->id}}</a> </td>
                                <td class="name-custom">{{$language->name}}</td>
                                <td class="icon-custom text-center">
                                    @if($language->icon)
                                        <span  class="{!! $language->icon !!}"></span>
                                        @else
                                        <p>-</p>
                                        @endif
                                </td>
                                <td>
                                    <div class="team">
                                        <a class="image-custom team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="Daniel Canales">
                                            <img src="{{config('app.path_public_storage')}}{{getPathThumb($language->image)}}" class="rounded-circle avatar-xs m-1" alt="">
                                        </a>
                                    </div>
                                </td>
                                <td class="url-custom text-center">{{$language->url}}</td>
                                <td class="action-custom">
                                    <a href="{{route('update_language',['id'=>$language->id])}}" class="text-primary btn btn-sm btn-rounded btn-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{\Illuminate\Support\Facades\Lang::get('en.pt_edit')}}"><i class="mdi mdi-pencil font-size-12"></i></a>
                                    <a onclick="getOneObj(this)" data-id="{{$language->id}}" data-url="{{route('delete_language')}}" data-flag="1" class="text-danger btn btn-sm btn-rounded btn-outline-danger" data-target=".confirmModal" data-toggle="modal" data-placement="top"  data-original-title="{{\Illuminate\Support\Facades\Lang::get('en.pt_delete')}}"><i class="mdi mdi-close font-size-12"></i></a>
                                   </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div>
                            <div onclick="getAllObj(this)" data-url="{{route('delete_language')}}" data-flag="all" data-target=".confirmModal" data-toggle="modal" class="btn btn-primary" >Delete All</div>
                            <a onclick=""></a>
                        </div>
                    </div>
                  {{$data->links()}}
                </div>
            </div>
        </div>
    </div><!-- end row -->
    <!-- end table -->

@endsection



