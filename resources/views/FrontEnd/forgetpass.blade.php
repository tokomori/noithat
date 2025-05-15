@extends('Layout_user')
@section('title')
  Đăng nhập
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
            <h2>Quên mật khẩu</h2>
             </div>
                <div class="content">
                    <p>Vui lòng nhập Email để lấy lại mật khẩu.</p>
                <form action="{{ url('/recoverpass') }}" method="POST">
                 @csrf
                     
                     <ul class="form-list">
                         <li>
                         <label for="email">Địa chỉ Email <span class="required">*</span></label>
                         <input type="text" title="email" class="input-text required-entry" id="email" name="email">
                         </li>
                     </ul>
                     <div class="buttons-set">
                         <button id="send2" name="send" type="submit" class="button login"><span>Gửi</span></button>
                     </div>
                </form>
              </div>
            </fieldset>
          </div>
        </article>
        <!--	///*///======    End article  ========= //*/// -->
      </div>
    </div>
  </div>
</div>
<!-- Main Container End -->
@endsection

