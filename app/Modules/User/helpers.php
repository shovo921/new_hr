<?php

if (!function_exists('appApiResponse')) {

    function appApiResponse($code, $message="The given data was invalid.", $errors=null, $data = null) {

        if(!is_null($errors))
        {
            if(!is_object($errors))
            {
                $errors = (object)$errors;
            }
        }
        return response()->json(
                        [
                    'message' => $message,
                    'errors' => $errors,
                    'data' => $data,
                    'code' => $code
                        ], 200);
    }

}

if (!function_exists('unique_mobile_no_check')) {

    function unique_mobile_no_check($mobile_no, $type, $id = false) {
        if ($id) {
            return \App\User::where('mobile_no', $mobile_no)->where('type', $type)->where('id', '!=', $id)->exists();
        } else {
            return \App\User::where('mobile_no', $mobile_no)->where('type', $type)->exists();
        }
    }

}
if (!function_exists('unique_email_check')) {

    function unique_email_check($email, $type, $id = false) {

        if ($id) {
            return \App\User::where('email', $email)->where('type', $type)->where('id', '!=', $id)->exists();
        } else {
            return \App\User::where('email', $email)->where('type', $type)->exists();
        }
    }

}

function mobileNoValidate($mobile_no,$type='local') {
    $data= (new \App\Http\Requests\MobileNumberValidator())->validate($mobile_no);
    if($type == 'local')
    {
        if($data['type']=='local')
        {
            return $data['is_valid'];
        }
    }
    else
    {
        return $data['is_valid'];
    }

    return false;

}

function companies()
{
    return \App\Modules\Companies\Models\Companies::pluck('company_name','id');
}

function branches()
{
    return \App\Modules\Branch\Models\Branch::where('branch_id', 'not like', 'H%')->pluck('branch_name','id');
}

function products()
{
    $product = App\Modules\Products\Models\Products::select('name')->groupBy('name')->pluck('name');
    if($product)
    {
        return json_encode($product->toArray());
    }
    else
    {
        return [];
    }
}
function category()
{
    $category = App\Modules\Products\Models\Category::OrderBy('name','asc')->pluck('name','id');
    if($category)
    {
        return $category->toArray();
    }
    else
    {
        return [];
    }
}
function expenseCategoryList()
{
    $category = \App\Modules\Accounting\Models\ExpenseCategory::OrderBy('name','asc')->pluck('name','id');
    if($category)
    {
        return $category->toArray();
    }
    else
    {
        return [];
    }
}

function productStatus()
{
    return [
        '1'=>'Available',
        '0'=>'Unavailable'
    ];
}

function customerList()
{
     $customer = \App\Modules\CustomerManagement\Models\Customer::OrderBy('name','asc')->pluck('name','id');
    if($customer)
    {
        return $customer->toArray();
    }
    else
    {
        return [];
    }
}
function providerList()
{
    $customer = App\Modules\LoanManagement\Models\LoanProvider::OrderBy('name','asc')->pluck('name','id');
    if($customer)
    {
        return $customer->toArray();
    }
    else
    {
        return [];
    }
}


function stock_type(){
    return [
        'S'=>'Stock item can be sold to anyone',
        'P'=>'Product item can be sold to that specific company'
    ];
}

function price_type(){
    return [
        'N'=>'Normal Price',
        'S'=>'Special price'
    ];
}