@extends('agent.layouts.agent_template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        修改密码
    </h1>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            修改密码
        </h6>
    </div>
    <form class="user" action="{{url('/editPassword')}}" method="post" onsubmit="return checkForm();">
        @csrf
        <div class="card-body pt-4">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">原密码：</label>
                <div class="col-sm-9">
                    <input type="password" name="old_password" required class="form-control form-control-user" placeholder="请输入原密码">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">新密码：</label>
                <div class="col-sm-9">
                    <input type="password" name="new_password"  id="new_password" class="form-control form-control-user" placeholder="请输入新密码" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">确认新密码：</label>
                <div class="col-sm-9">
                    <input type="password" id="re_password"  class="form-control form-control-user" placeholder="请再次输入新密码" required>
                </div>
            </div>
            <div class="form-group row pt-3">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        修改密码
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
<script>
    
    function checkForm() {
        var new_password = $("#new_password").val();
        var re_password = $("#re_password").val();
        if (new_password.length < 6) {
            alert('密码至少6位数');
            return false;
        }
        if (new_password != re_password) {
            alert('两次密码输入不一致');
            return false;
        }
    }
</script>
@endsection