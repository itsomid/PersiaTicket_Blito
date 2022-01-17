<div class="user-create user-edit" >
    <div class="p-window">

        <div class="row">
            <form role="form" enctype="multipart/form-data" action="{{ route('users/save', isset($user) ? ['id' => $user->id] : [] ) }}" method="post">
                @if( !is_null(session('error')) )
                    <div class="alert alert-danger">
                        <strong>{{ session('error') }}</strong>
                    </div>
                @endif
                {{ csrf_field() }}
                <div class="row">

                    <label class="pop-title">
                        @if(isset($user))
ویرایش کاربر
                        @else
                            ثبت کاربر جدید
                        @endif

                    </label>
                </div>
                <div class="col-sm-6">  <div class="form-group"> <input name="first_name" type="text" placeholder="نام" class="form-control" value="{{ isset($user) ? $user->first_name : old('first_name') }}"> </div></div>
                 <div class="col-sm-6"><div class="form-group"> <input name="last_name" type="text" placeholder="نام خانوادگی" class="form-control" value="{{isset($user) ? $user->last_name : old('last_name')}}"> </div></div>
                 <div class="col-sm-6"><div class="form-group"><input name="mobile" type="tel" placeholder="شماره موبایل" class="form-control" value="{{ isset($user) ? $user->mobile : old('mobile') }}"></div> </div>
                 <div class="col-sm-6"><div class="form-group"><input name="email" type="email" placeholder="ایمیل" class="form-control" value="{{ isset($user) ? $user->email : old('email') }}"></div> </div>
                 <div class="col-sm-6"><div class="form-group"><input name="password" type="password" placeholder="رمز عبور" class="form-control" pattern="[A-Za-z0-9]{6,13}"></div> </div>
                 <div class="col-sm-6"><div class="form-group"><input name="retype_password" type="password" placeholder="تکرار رمز عبور" class="form-control"></div> </div>
                 <div class="col-sm-12"><div class="form-group"><label> تصویر پروفایل<input name="avatar" type="file" class="form-control"></label>
                    @isset($user)
                    <img src="{{asset($user->avatar_url)}}" width="100px">
                    @endisset
                     </div> </div>
                    <div class="col-sm-6">
                <div class="checkbox"><label>
                        <input name="producer" type="checkbox" {{ isset($user) ? $user->access_level == 5 ? 'checked': '' : old('producer') ? 'checked' : '' }}>
                    </label> تهیه کننده</div>
                    </div>     <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-2 control-label">وضعیت</label>
                    <div class="col-sm-10">
                        <select class="form-control m-b" name="status">
                            //'enabled','disabled','pending'
                                <option value="enabled" {{ isset($user) ? $user->status == "enabled" ? "selected=\"selected\"" : "" : "" }}>{{trans('userstatus.enabled')}}</option>
                                <option value="disabled" {{ isset($user) ? $user->status == "disabled" ? "selected=\"selected\"" : "" : "" }}>{{trans('userstatus.disabled')}}</option>
                                <!--<option value="pending" {{ isset($user) ? $user->status == "pending" ? "selected=\"selected\"" : "" : "" }}>{{trans('userstatus.pending')}}</option>-->
                        </select>
                    </div>
                </div>
                    </div>
                <button class="btn btn-sm btn-primary pull-right" type="submit">ذخیره</button>
                <a href="#" class="btn btn-sm btn-warning close-popup">لغو</a>
            </form>
        </div>
    </div></div>