<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'updateUserBasicInfo',
        'updateEmployee',
        'updateEmployeeOtherInfo',
        'updateEmployeeSkillInfo',
        'updateEmployeeTransferInfo',
        'updateEmployeeExperienceInfo',
        'getEmployeeSalarySlaveInfo',
        'getEmployeePromotedSalaryInfo',
        'getUpdatedEmployeeID',
        'getEmployeeFileNumber',
        'getEmployeeInfo',
        'getEmployeeCurrentSalaryInfo',
    ];
}
