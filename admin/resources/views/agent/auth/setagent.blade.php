@extends('agent.layouts.agent_template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        设置代理返点
    </h1>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            设置代理返点
        </h6>
    </div>
    <form class="user" action="{{url('/changefanshui')}}" method="post" onsubmit="return checkForm();">
        @csrf
        <div class="card-body pt-4">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">用户名：</label>
                <div class="col-sm-9 pt-2">
                   {{$userinfo->username}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">返点比例：</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" name="fanshui"  id="fanshui" value="{{$userinfo->fanshuifee}}" class="form-control form-control-user" placeholder="请输入返点比例" required>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden"  name="uid"  value=" {{$userinfo->id}}">
            <div class="form-group row pt-3">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        设置代理
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
        var fanshui = $("#fanshui").val();
        if (!fanshui || fanshui < 0 || isNaN(fanshui)) {
            alert('请输入有效的代理返点比例');
            return false;
        }
        return true;
    }
</script>
@endsection
