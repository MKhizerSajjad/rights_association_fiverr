<x-app-layout>
    <div class="content-page rtl-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12" bis_skin_checked="1">
                    <div class="card" bis_skin_checked="1">
                    <div class="card-header d-flex justify-content-between" bis_skin_checked="1">
                        <div class="header-title" bis_skin_checked="1">
                            <h4 class="card-title">Book New Appiontment</h4>
                        </div>
                    </div>
                    <div class="card-body" bis_skin_checked="1">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger" role="alert" bis_skin_checked="1">
                                <div class="iq-alert-icon" bis_skin_checked="1">
                                    <i class="ri-information-line"></i>
                                </div>
                                <div class="iq-alert-text" bis_skin_checked="1">
                                    <b>Whoops!</b> There were some problems with your inputs
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                        @endif

                        <div class="new-user-info" bis_skin_checked="1">
                            <form method="POST" action="{{ route('appointment.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row" bis_skin_checked="1">
                                    <div class="form-group col-sm-6" bis_skin_checked="1">
                                        <label>Case Type <span class="text text-danger">*</span></label>
                                        <div class="dropdown" bis_skin_checked="1">
                                            <select class="form-control" id="case_type" name="case_type">
                                                <option>Select Case Type</option>
                                                @foreach (getCaseTypes() as $key => $label)
                                                    @php $key = ++$key; @endphp
                                                    <option {{ (old('case_type') == $key) ? 'selected="selected"' : '' }} value="{{ $key }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6" bis_skin_checked="1">
                                        <label for="datetime">Date Time <span class="text text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="datetime" name="datetime" placeholder="Date Time" value="{{ old('datetime') }}">
                                    </div>
                                    @if (Auth::user()->user_type == 1)
                                        <div class="form-group col-sm-4" bis_skin_checked="1">
                                            <label>Employee <span class="text text-danger">*</span></label>
                                            <div class="dropdown" bis_skin_checked="1">
                                                <select class="form-control" id="employee" name="employee">
                                                    <option>Select Employee</option>
                                                    @foreach ($employees as $key => $employee)
                                                        <option {{ (old('employee') == $employee->id) ? 'selected="selected"' : '' }} value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4" bis_skin_checked="1">
                                            <label>Customer <span class="text text-danger">*</span></label>
                                            <div class="dropdown" bis_skin_checked="1">
                                                <select class="form-control" id="customer" name="customer">
                                                    <option>Select Customer</option>
                                                    @foreach ($customers as $key => $customer)
                                                        <option {{ (old('customer') == $customer->id) ? 'selected="selected"' : '' }} value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-4" bis_skin_checked="1">
                                            <label>Status <span class="text text-danger">*</span></label>
                                            <div class="dropdown" bis_skin_checked="1">
                                                <select class="form-control" id="status" name="status">
                                                    <option>Select Status</option>
                                                    @foreach (getAppointmentStatus() as $key => $label)
                                                        @php $key = ++$key; @endphp
                                                        <option {{ (old('status') == $key) ? 'selected="selected"' : '' }} value="{{ $key }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @elseif(Auth::user()->user_type == 2)
                                        <div class="form-group col-sm-6" bis_skin_checked="1">
                                            <label>Customer <span class="text text-danger">*</span></label>
                                            <div class="dropdown" bis_skin_checked="1">
                                                <select class="form-control" id="customer" name="customer">
                                                    <option>Select Customer</option>
                                                    @foreach ($customers as $key => $customer)
                                                        <option {{ (old('customer') == $customer->id) ? 'selected="selected"' : '' }} value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6" bis_skin_checked="1">
                                            <label>Status <span class="text text-danger">*</span></label>
                                            <div class="dropdown" bis_skin_checked="1">
                                                <select class="form-control" id="status" name="status">
                                                    <option>Select Status</option>
                                                    @foreach (getAppointmentStatus() as $key => $label)
                                                        @php $key = ++$key; @endphp
                                                        <option {{ (old('status') == $key) ? 'selected="selected"' : '' }} value="{{ $key }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group col-md-12" bis_skin_checked="1">
                                        <label for="note">Note</label>
                                        <textarea type="text" class="form-control" id="note" name="note" placeholder="Note">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right">Add</button>
                                <a href="{{route('appointment.index')}}" class="btn btn-secondary float-right mr-1">Cancel</a>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
