@extends('layouts.app')
@extends('layouts.modal_small')
@include('layouts.menu')
@section('breadcrumb')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/') }}">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Bulk Salary Upload</span>
            </li>
        </ul>
        <div class="page-toolbar">
            <div class="pull-right">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase hidden-xs">{{ date('D, M d, Y') }}</span>&nbsp;
            </div>
        </div>
    </div>
    <!-- END PAGE BAR -->
@stop


@section('content')
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <div class="row">
        <div class="col-md-12" style="margin-top:20px;">
            <div class="table-responsive">
                @if (session('msg_success'))
                    <div class="alert alert-success">
                        {{ session('msg_success') }}
                    </div>
                @endif
                @if (session('msg_error'))
                    <div class="alert alert-error">
                        {{ session('msg_error') }}
                    </div>
                @endif
                <!-- BEGIN EXAMPLE TABLE PORTLET-->

                <div class="portlet blue box">

                    <div class="portlet-title">

                        <label>Browse the file</label>
                        <div class="form-group">
                            <input type="file" name="file" required="required"
                                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>


                        <div class="caption">
                            <i class="icon-settings"></i>
                            <span class="caption-subject bold uppercase">Uploaded List</span>
                        </div>
                        <div class="tools"></div>
                        <br><br>
                        <div>
                            <a href="{{ route('salIncrement.bulkListUpdate') }}"
                               class="btn btn-circle btn green btn-sm purple pull-left">
                                <i class="fa fa-edit"></i>
                                Check File</a>
                        </div>
                        <div>
                            <a href="{{ route('salIncrement.bulkAuthorize') }}"
                               class="btn btn-circle btn green btn-sm red pull-left">
                                <i class="fa fa-edit"></i>
                                Authorize</a>
                        </div>
                    </div>

                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
                               id="sample_5">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="all">SI No</th>
                                <th class="min-phone-l">Employee Info</th>
                                <th class="min-phone-l">Designation</th>
                                <th class="min-phone-l">Inc Count</th>
                                <th class="min-phone-l">Current Slab</th>
                                <th class="min-phone-l">Updated Slab</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @if(isset($data['bulkIncrement']))

                                @foreach($data['bulkIncrement'] as $info)
                                        <?php $i++; ?>
                                    <tr>
                                        <td></td>
                                        <td>{{ $i }}</td>
                                        <td>{{ $info->employeeInfo->employee_name.'-'.$info->employee_id ?? '' }}</td>
                                        <td>{{ $info->employeeInfo->designation ?? ''}}</td>
                                        <td>{{ $info->inc_count ?? ''}}</td>
                                        <td>{{ $info->employeeSalIno->current_inc_slave ?? ''}}</td>
                                        @php
                                            $updatedSlab = $info->employeeSalIno->current_inc_slave + $info->inc_count;
                                        @endphp
                                        <td>{!! $info->updated_slab == null ? $updatedSlab : $info->updated_slab !!}
                                        </td>

                                        <td>
                                            @if($info->status != 1)
                                                <button type="button" value="{{ $info->id ?? ''}}"
                                                        class="btn btn-default editbtn btn-sm"><i
                                                            class="fa fa-eye"></i>
                                                </button>

                                            @else
                                                <button type="button" disabled
                                                        class="btn btn-default editbtn btn-sm"><i
                                                            class="fa fa-eye"></i>
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                No Data found
                            @endif
                            </tbody>
                        </table>
                        {{-- Starting Edit Modal --}}
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Detail Salary Info</h5>
                                    </div>
                                    <label for="employee"> Employee</label><input readonly name="employee" id="employee"
                                                                                  required class="form-control">

                                    <div class="modal-body">

                                        <ul id="update_msgList"></ul>

                                        <input type="hidden" id="stud_id"/>

                                        <table class="table table-bordered" id="edit_table">
                                            <thead>
                                            <tr>
                                                <th class="min-phone-l">Basic</th>
                                                <td><label for="basic"></label><input readonly name="basic" id="basic"
                                                                                      required
                                                                                      class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">House Rent</th>
                                                <td><label for="house_rent"></label><input readonly name="house_rent"
                                                                                           id="house_rent" required
                                                                                           class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">House Maintenance</th>
                                                <td><label for="house_maintenance"></label><input readonly
                                                                                                  name="house_maintenance"
                                                                                                  id="house_maintenance"
                                                                                                  required
                                                                                                  class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">Medical</th>
                                                <td><label for="medical"></label><input readonly name="medical"
                                                                                        id="medical"
                                                                                        required
                                                                                        class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">L.F.A.</th>
                                                <td><label for="lfa"></label><input readonly name="lfa" id="lfa"
                                                                                    required
                                                                                    class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">Conveyance</th>
                                                <td><label for="conveyance"></label><input readonly name="conveyance"
                                                                                           id="conveyance" required
                                                                                           class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">Utility</th>
                                                <td><label for="utility"></label><input readonly name="utility"
                                                                                        id="utility"
                                                                                        required
                                                                                        class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">PF</th>
                                                <td><label for="pf"></label><input readonly name="pf" id="pf" required
                                                                                   class="form-control"></td>
                                            </tr>
                                            <tr>

                                                <th class="min-phone-l">Updated Slab</th>
                                                <td><label for="updated_slab"></label><input readonly
                                                                                             name="updated_slab"
                                                                                             id="updated_slab" required
                                                                                             class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th class="min-phone-l">Gross Total</th>
                                                <td><label for="gross_total"></label><input readonly name="gross_total"
                                                                                            id="gross_total" required
                                                                                            class="form-control"></td>
                                            </tr>

                                            </thead>
                                        </table>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        {{-- End Edit Modal --}}


                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->

@endsection

@section('script')
    <script>
        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var id = $(this).val();
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: base_url + "/incrementDetail/" + id,
                success: function (response) {
                    //console.log('Salary',response.amount.sal.conveyance);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        $('#basic').val(response.amount.sal.current_basic);
                        $('#house_rent').val(response.amount.sal.house_rent);
                        $('#conveyance').val(response.amount.sal.conveyance);
                        $('#house_maintenance').val(response.amount.sal.house_maintenance);
                        $('#medical').val(response.amount.sal.medical);
                        $('#lfa').val(response.amount.sal.lfa);
                        $('#utility').val(response.amount.sal.utility);
                        $('#pf').val(response.amount.sal.pf);
                        $('#updated_slab').val(response.amount.sal.current_inc_slave);
                        $('#gross_total').val(response.amount.sal.gross_total);

                        let employee_id = response.employee_id;
                        let employee_name = response.employee_name;
                        let employee = employee_name+' - '+employee_id;

                        $('#employee').val(employee);
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });
    </script>
@endsection


{{--
@section('small_modal_title', 'import'.' Excel')
@section('small_modal_content')
    <label>Browse the file</label>
    <div class="form-group">
        <input type="file" name="file" required="required"
               accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
    </div>
@endsection
<h1>Test</h1>
@section('small_modal_btn_label', 'import'))
@section('small_modal_btn_onclick', "$('.btn-submit').addClass('disabled');$('.btn-submit').html('<i class=\"fa fa-spin fa-spinner\"></i>&nbsp; ".'Loading, please wait..'."');")
@section('small_modal_form', true)
@section('small_modal_method', 'POST')
@section('small_modal_url', route('salIncrement.import'))--}}
