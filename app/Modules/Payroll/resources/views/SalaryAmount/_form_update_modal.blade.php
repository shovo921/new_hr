                <div class="form-body">
    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%"
           id="sample_5">
        <thead>
        <tr>
            <th class="all">SI No</th>
            <th class="min-phone-l">Payment Head</th>
            <th class="min-phone-l">Type</th>
            <th> Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 0 ?>
        @foreach($salaryPaySlips as $salaryPaySlip)
                <?php $i++; ?>
            <tr>
                <td>{{ $i }}</td>
                <td>
                    <div class="form-group">
                        {{--<label class="col-md-4 control-label">{{$salaryPaySlip->payType->description ?? ''}}</label>--}}
                        <label class="col-md-4 control-label">
                            {!! Form::select('ptype_id', $payHeadList, $value = $salaryPaySlip->ptype_id ?? '', array('id'=>'ptype_id', 'class' => 'form-control', 'required'=>"")) !!}
                        </label>
                        <div class="col-md-8">
                            {!! Form::text('ptype_id', $value =number_format((double)$salaryPaySlip->amount, 2, '.', '') ?? '', array('id'=>'amount', 'class' => 'form-control')) !!}
                        </div>
                    </div>
                </td>
                <td>{{$salaryPaySlip->status1}}</td>

                <td>
                    <a href="{{ url('') }}"
                       class="btn btn-circle btn green btn-sm purple pull-left">
                        <i class="fa fa-edit"></i>
                        Edit</a>
                    <a href="{{ url('') }}"
                       class="btn btn-circle btn green btn-sm purple pull-left">
                        <i class="fa fa-edit"></i>
                        Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

{{--    @foreach($salaryPaySlips as $salaryPaySlip)
    <div class="form-group">
        <label class="col-md-4 control-label">{{$salaryPaySlip->payType->description ?? ''}}</label>
        <label class="col-md-4 control-label">
            {!! Form::select('ptype_id', $payHeadList, $value = $salaryPaySlip->ptype_id ?? '', array('id'=>'ptype_id', 'class' => 'form-control', 'required'=>"")) !!}
        </label>
        <div class="col-md-8">
            {!! Form::text('ptype_id', $value =number_format((double)$salaryPaySlip->amount, 2, '.', '') ?? '', array('id'=>'amount', 'class' => 'form-control')) !!}
        </div>
    </div>
    @endforeach--}}

{{--    <div class="form-group">
        <label class="col-md-4 control-label">Add Payment Head<span class="required">*</span></label>
        <div class="col-md-8">
            {!! Form::select('ptype_id', $payHeadList, $value = null, array('id'=>'ptype_id', 'class' => 'form-control', 'required'=>"")) !!}
            @if($errors->has('ptype_id'))<span class="required">{{ $errors->first('ptype_id') }}</span>@endif
        </div>
    </div>--}}


    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            {!! Form::submit('Submit', array('class' => "btn btn-primary")) !!} &nbsp;
            <a href="{{  url('salary-amount') }}" class="btn btn-success">Back</a>
        </div>

    </div>
</div>