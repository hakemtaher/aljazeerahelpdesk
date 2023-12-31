@extends('admin.layouts.app', [ 'current_page' => 'tickets' ])

@section('content')

    @push('header-buttons')
        <div class="col-lg-6 col-5 text-right">
          <a href="{{ route('tickets.index') }}" class="btn btn-sm btn-icon btn-neutral">
            <i data-feather="arrow-left" stroke-width="3" width="12"></i> {{ __('labels.tickets') }}</a>
        </div>
    @endpush

    @include('admin.layouts.headers.cards', ['title' => __('labels.tickets')])
    
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('labels.new_ticket') }}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{ route('tickets.store') }}" id="my-form" autocomplete="off">
                            @csrf
                            @method('post')

                            <div class="pl-lg-4">

                                <div class="form-group{{ $errors->has('customer') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-customer">{{ __('labels.customer') }}</label>
                                    <select name="customer_id" id="input-customer" class="form-control" required>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer')==$customer->id ? 'selected' :'' }}>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('customer'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('customer') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('department_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-department_id">{{ __('labels.department') }}</label>
                                    <select name="department_id" id="input-department_id" class="form-control" required>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id')==$department->id ? 'selected' :'' }}>{{$department->name[app()->getLocale()]??$department->name['en']}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('department_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('department_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('priority_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-priority_id">{{ __('labels.priority') }}</label>
                                    <select name="priority_id" id="input-priority_id" class="form-control" required>
                                        @foreach($priorities as $priority)
                                            <option value="{{ $priority->id }}" {{ old('priority_id')==$priority->id ? 'selected' :'' }}>{{$priority->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('priority_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('priority_id') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-title">{{ __('labels.title') }}</label>
                                    <input type="text" name="title" id="input-title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title') }}" required autofocus>

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-description">{{ __('labels.description') }}</label>

                                    <textarea name="description" id="input-description" rows="6" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="{{ __('labels.description') }}" required>{{ old('description') }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            
                                <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" name="send_email_customer" id="customCheckLogin" type="checkbox" value="yes" {{ old('send_email_customer') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheckLogin">
                                            <span class="text-muted">{{ __('labels.notify_customer') }}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="text-left">
                                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    
                </div>
            </div>
        </div>

        @include('admin.layouts.footers.auth')



    </div>
@endsection


        @push('js')

        <script>
        </script>
        @endpush
