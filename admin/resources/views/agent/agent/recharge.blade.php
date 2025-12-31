@extends('agent.layouts.agent_template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        下级充值
    </h1>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            下级充值
        </h6>
    </div>
    <form class="user" action="{{url('/recharge')}}" method="post" onsubmit="return checkForm();">
        @csrf
        <div class="card-body pt-4">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label text-right font-weight-bold">金额：</label>
                <div class="col-sm-9">
                    <input type="number" name="amount" id="amount" required class="form-control form-control-user" placeholder="请输入金额">
                </div>
            </div>
           
            <div class="form-group row pt-3">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        充值
                    </button>
                </div>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{$user_id}}">
        
    </form>
</div>
@endsection
@section('js')
<script>
    
    function checkForm() {
        var amount = $("#amount").val();
        if (!amount) {
            alert('请输入金额');
            return false;
        }
    }
</script>
@endsection