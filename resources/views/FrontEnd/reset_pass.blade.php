@extends('Layout_user')
@section('title')
  Điền mật khẩu mới
@endsection
@section('content')
<!-- Main Container -->
<div class="main-container col1-layout">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
        <article class="col-main">
          <div class="account-login">
            <div class="page-title">
            <h2>Điền mật khẩu mới</h2>
             </div>
                    @php
                        $remember_token = request()->get('remember_token', '');
                        $email = request()->get('email', '');
                    @endphp
                    <fieldset class="col2-set">
                        <div class="col-1 new-users">
                    <div class="col-2 register-users">
                <form action="{{ url('/updatepass') }}" method="POST">
                 @csrf                     
                    <ul class="form-list">
                        <li>
                        <input type="hidden" name="email" value={{$email}}>
                        <input type="hidden" name="remember_token" value={{$remember_token}}>
                        <label for="text">Mật khẩu mới <span class="required">*</span></label>
                        <input type="text" title="password" class="input-text required-entry" id="password" name="password">
                        </li>
                    </ul>
                    <div class="buttons-set">
                        <button id="send2" name="send" type="submit" class="button login"><span>Gửi</span></button>
                    </div>
                </form>
                    </div>
                        </div>
                    </fieldset>
<!-- Main Container End -->
            </div>
          </div>
        </article>
    </div>
  </div>
</div>
@endsection

