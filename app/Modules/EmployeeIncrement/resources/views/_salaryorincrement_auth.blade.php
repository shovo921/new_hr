<div class="form-body">
        <div class="form-group">
            <label class="col-md-4 control-label">Employee Name</label>
            <div class="col-md-8">
                <input type="text" name="employee_id" class="form-control" value="{{$salaryIncrementSlave->employee_id}}">
            </div>
        </div>
        {{--<div class="form-group hidden" id="designationArea">
            <label class="col-md-4 control-label">Employee Designation</label>
            <div class="col-md-8" id="designationInfo"></div>
        </div>--}}
        <div class="form-group">
            <label class="col-md-4 control-label">Current Increment Slab</label>
            <div class="col-md-8">
                <input type="text" name="current_inc_slave" class="form-control" value="{{$salaryIncrementSlave->current_inc_slave}}">

            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Basic Salary<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="current_basic" class="form-control" value="{{$salaryIncrementSlave->current_basic}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">House Rent<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="house_rent" class="form-control" value="{{$salaryIncrementSlave->house_rent}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Medical<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="medical" class="form-control" value="{{$salaryIncrementSlave->medical}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Conveyance</label>
            <div class="col-md-8">
                <input type="text" name="conveyance" class="form-control" value="{{$salaryIncrementSlave->conveyance}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">House Maintenance<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="house_maintenance" class="form-control" value="{{$salaryIncrementSlave->house_maintenance}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Utility<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="utility" class="form-control" value="{{$salaryIncrementSlave->utility}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">LFA<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="lfa" class="form-control" value="{{$salaryIncrementSlave->lfa}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Car Allowance</label>
            <div class="col-md-8">
                <input type="text" name="car_allowance" class="form-control" value="{{$salaryIncrementSlave->car_allowance}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Consolidated Amount</label>
            <div class="col-md-8">
                <input type="text" name="consolidated_amount" class="form-control" value="{{$salaryIncrementSlave->consolidated_amount}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">OTHERS</label>
            <div class="col-md-8">
                <input type="text" name="others" class="form-control" value="{{$salaryIncrementSlave->others}}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Gross Salary<span class="required">*</span></label>
            <div class="col-md-8">
                <input type="text" name="gross_total" class="form-control" value="{{$salaryIncrementSlave->gross_total}}">
            </div>
        </div>
       {{-- <div class="form-group hidden" id="basicArea">
            <label class="col-md-4 control-label">Employee Designation</label>
            <div class="col-md-8" id="basicInfo"></div>
        </div>--}}


    <div class="form-group col-md-offset-4">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
    </div>
</div> 

