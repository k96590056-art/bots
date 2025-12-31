@extends('agent.layouts.agent_template')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">下级会员返水记录</h1>
        <form class="form-inline ml-auto" action="/rebate">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="请选择开始时间" name="start" id="start1">&nbsp;&nbsp;
                <input type="text" class="form-control bg-light border-0 small" placeholder="请选择结束时间" name="end" id="end1">&nbsp;&nbsp;
                <input type="text" class="form-control bg-light border-0 small" placeholder="请输入账号..." name="username" aria-label="Search" aria-describedby="basic-addon2">
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
            <h6 class="m-0 font-weight-bold text-primary">下级会员转账记录</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>账号</th>
                        <th>操作类型</th>
                        <th>操作额度</th>
                        <th>操作前额度</th>
                        <th>操作后额度</th>
                        <th>操作时间</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->user_data->username}}</td>
                            <td>返水金额</td>
                            <td>
                                {{$item->money}}
                            </td>
                            <td>{{$item->before_money}}</td>
                            <td>{{$item->after_money}}</td>
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
