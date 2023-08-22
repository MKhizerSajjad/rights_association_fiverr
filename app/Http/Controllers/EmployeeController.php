<?php

namespace App\Http\Controllers;

use Hash;
use Auth;
use App\Models\Employee;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Employee::orderBy('first_name', 'DESC')->paginate(1);


        $users = Employee::with('countries:id,name')->where('id', '!=', Auth::user()->id)->where('user_type', 2)->orderBy('first_name','DESC');

        if ($request->has('first_name') && $request->first_name != '') {
            $first_name = $request->first_name;
            $users = $users->where('first_name', 'LIKE', $first_name.'%');
        }

        if ($request->has('last_name') && $request->last_name != '') {
            $last_name = $request->last_name;
            $users = $users->where('last_name', 'LIKE', $last_name.'%');
        }

        if ($request->has('email') && $request->email != '') {
            $email = $request->email;
            $users = $users->where('email', 'LIKE', $email.'%');
        }

        if ($request->has('mobile_number') && $request->mobile_number != '') {
            $mobile_number = $request->mobile_number;
            $users = $users->where('mobile_number', 'LIKE', $mobile_number.'%');
        }

        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $users = $users->where('status', $status);
        }

        if ($request->has('address') && $request->address != '') {
            $address = $request->address;
            $users = $users->where('address', 'LIKE', '%'.$address.'%');
        }

        if ($request->has('zipcode') && $request->zipcode != '') {
            $zipcode = $request->zipcode;
            $users = $users->where('zipcode', 'LIKE', '%'.$zipcode.'%');
        }

        $data = $users->paginate(10);

        return view('admin.employee.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 1);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'picture' => 'file|mimes:jpeg,jpg,gif,png|max:2048',
            'first_name' => 'required|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|max:255|unique:users',
            'mobile_number' => 'min:12|max:18|unique:users',
            'status' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->all();

        // Picture
        if (isset($data['picture'])) {
            $imageStorage = public_path('images/users');
            $imageExt = array('jpeg', 'gif', 'png', 'jpg', 'webp');
            $picture = $request->picture;
            $extension = $picture->getClientOriginalExtension();

            if(in_array($extension, $imageExt)) {
                $sluggedName = Str::slug($request->first_name).'-'.Str::slug($request->last_name);
                $data['picture'] = $image = $sluggedName.'.'.$extension;
                $picture->move($imageStorage, $image); // Move File
            }
        }

        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);
        $data['user_type'] = 2;
        $user = Employee::create($data);

        return redirect()->route('employee.index')->with('success','Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $data = [
            'employee' => $employee,
        ];
        return view('admin.employee.show', compact($data));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $employee = Employee::find($employee->id);
        return view('admin.employee.edit',compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {

        $this->validate($request, [
            'picture' => 'file|mimes:jpeg,jpg,gif,png|max:2048',
            'first_name' => 'required|regex:/^[\pL\s]+$/u',
            'last_name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email|max:255|unique:users',
            'mobile_number' => 'min:12|max:18|unique:users',
            'status' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->all();

        // Picture
        if (isset($data['picture'])) {
            $imageStorage = public_path('images/users');
            $imageExt = array('jpeg', 'gif', 'png', 'jpg', 'webp');
            $picture = $request->picture;
            $extension = $picture->getClientOriginalExtension();

            if(in_array($extension, $imageExt)) {
                $sluggedName = Str::slug($request->first_name).'-'.Str::slug($request->last_name);
                $data['picture'] = $image = $sluggedName.'.'.$extension;
                $picture->move($imageStorage, $image); // Move File
            }
        }

        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
            // unset($data['password_confirmation']);
        }else{
            $data = Arr::except($data,array('password'));
            $data = Arr::except($data,array('password_confirmation'));
        }

        $user = Employee::find($employee->id);
        $user->update($data);

        return redirect()->route('employee.index')->with('success','Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employee.index')->with('success','Employee deleted successfully');
    }
}
