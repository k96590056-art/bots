@extends('agent.layouts.agent_template')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    @if(Auth::user()->agent_level <= 4)
    <h1 class="h3 mb-0 text-gray-800">添加下级代理</h1>
    @else
    <h1 class="h3 mb-0 text-gray-800">添加下级会员</h1>
    @endif
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        @if(Auth::user()->agent_level <= 4)
        <h6 class="m-0 font-weight-bold text-primary">注册代理资料</h6>
        @else
        <h6 class="m-0 font-weight-bold text-primary">注册会员资料</h6>
        @endif
    </div>
    <form class="user" action="/add-member" method="post" onsubmit="return checkForm()">
        @csrf
        <div class="card-body pt-4">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">账号：</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control form-control-user" placeholder="* 请输入长度6-9位,可输入英文字母 或数字" required minlength="6">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">密码：</label>
                <div class="col-sm-9">
                    <input type="password" id="password" name="password" class="form-control form-control-user" placeholder="* 密码规则:须为6-24位英 文或数字的字符" required minlength="6">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">确认密码：</label>
                <div class="col-sm-9">
                    <input type="password" id="repassword" class="form-control form-control-user" placeholder="* 请再次输入密码" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">真实姓名：</label>
                <div class="col-sm-9">
                    <input type="text" name="realname" class="form-control form-control-user" placeholder="* 请输入中文姓名" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">取款密码：</label>
                <div class="col-sm-9 pt-2">
                    * 默认取款密码为<span class="text-danger font-weight-bold">【123456】</span>会员登录后可自行更改，请务必记住！
                </div>
            </div>
            <div class="form-group row pt-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        立即注册
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@section('js')
<script src="/agent/js/laydate/laydate.js"></script>
<script>
    $('#collapseFour').addClass('show');
</script>
<script>
function checkForm() {
    var password = $('#password').val();
    var repassword = $('#repassword').val();
    if (password != repassword) {
        alert('两次密码输入不一致');
        return false;
    }
}
</script>
@endsection