@extends('agent.layouts.agent_template')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5>下级操作日志</h5>
</div>

<div class="input-group" style="z-index:999; padding-left:0; padding-bottom:20px;">
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="/operate-log">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="请选择开始时间" name="start" id="start1">&nbsp;&nbsp;
            <input type="text" class="form-control bg-light border-0 small" placeholder="请选择结束时间" name="end" id="end1">&nbsp;&nbsp;
            <input type="text" class="form-control bg-light border-0 small" placeholder="请输入账号..." name="username" value="{{$username}}" aria-label="Search" aria-describedby="basic-addon2">
            <select name="type" class="form-control bg-light border-0 small" style="margin-left: 10px;">
                <option value="">全部类型</option>
                @foreach($typeMap as $key => $value)
                    <option value="{{$key}}" {{$type == $key ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">下级操作日志</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto; padding: 0 !important;">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align:center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>操作类型</th>
                        <th>登录IP</th>
                        <th>IP地址</th>
                        <th>描述</th>
                        <th>创建时间</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->user_data ? $item->user_data->username : '-'}}</td>
                        <td>{{$typeMap[$item->type] ?? '-'}}</td>
                        <td>{{$item->login_ip}}</td>
                        <td>{{$item->ip_address}}</td>
                        <td>{{$item->desc ?: '-'}}</td>
                        <td>{{$item->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers">
                    <ul class="pagination">
                        {{$list->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="/agent/js/laydate/laydate.js"></script>
<script>
    $('#collapseFour').addClass('show');
</script>
<script>
    lay('#version').html('-v' + laydate.v);

    //执行一个laydate实例
    laydate.render({
        elem: '#start1' //指定元素
    });

    laydate.render({
        elem: '#end1' //指定元素
    });
</script>
@endsection

