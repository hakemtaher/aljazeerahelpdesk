<div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col-8">
                <h3 class="mb-0">{{__('labels.new_department')}}</h3>
            </div>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('departments.store') }}" id="my-form" autocomplete="off">
            @csrf
            @method('post')

            <div class="pl-lg-4">
                <!-- English Name Input -->
                <div class="form-group{{ $errors->has('name_en') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-name-en">{{ __('labels.name') }} (English)</label>
                    <input type="text" name="name_en" id="input-name-en" class="form-control {{ $errors->has('name_en') ? ' is-invalid' : '' }}" placeholder="{{ __('Name in English') }}" value="{{ old('name_en') }}" required autofocus>

                    @if ($errors->has('name_en'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name_en') }}</strong>
                        </span>
                    @endif
                </div>

                <!-- Arabic Name Input -->
                <div class="form-group{{ $errors->has('name_ar') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-name-ar">{{ __('labels.name') }} (العربية)</label>
                    <input type="text" name="name_ar" id="input-name-ar" class="form-control {{ $errors->has('name_ar') ? ' is-invalid' : '' }}" placeholder="{{ __('Name in Arabic') }}" value="{{ old('name_ar') }}" required>

                    @if ($errors->has('name_ar'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name_ar') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('user') ? ' has-danger' : '' }}">
                    <label class="form-control-label" for="input-user">{{ __('labels.default_assigned_user') }}</label>
                    <select name="assigned_user_id" id="input-user" class="form-control" data-toggle="select">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_user_id')==$user->id ? 'selected' :'' }}>{{$user->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('assigned_user_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('assigned_user_id') }}</strong>
                        </span>
                    @endif
                    <span class="help-text text-muted" style="font-size: .8rem; font-style: italic;">{{ __('labels.future_tickets_message') }}</span>
                </div>

                <div class="text-left">
                    <button type="submit" class="btn btn-info mt-4">{{ __('labels.submit') }}</button>
                </div>
            </div>

        </form>
    </div>

</div>