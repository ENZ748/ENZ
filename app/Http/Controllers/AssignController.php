<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assigned;
use App\Models\Employees;
use App\Models\Equipments;

class AssignController extends Controller
{
    public function add()
    {
        $employees = Employees::all();
        $equipments = Equipments::all();

          return view('assign.add',compact('employees', 'equipments'));
    }
    public function assign()
    {
        Assigned::create([

        ]);
    }
}
