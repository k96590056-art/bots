@extends('agent.layouts.agent_template')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">区域会员列表</h1>
    <form class="form-inline ml-auto" action="/region-member-list" method="GET">
        <div class="input-group">
            <input type="text" name="username" class="form-control bg-light border-0 small" placeholder="请输入账号..." aria-label="Search" aria-describedby="basic-addon2" value="{{ request('username') }}">
            
            <select name="region_id" class="form-control bg-light border-0 small ml-2" style="height: auto;">
                <option value="">所有区域</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
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
        <h6 class="m-0 font-weight-bold text-primary">会员列表</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="text-align:center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>账号</th>
                        <th>姓名</th>
                        <th>区域</th>
                        <th>帐户类型</th>
                        <th>系统余额</th>
                        <th>游戏余额</th>
                        <th>创建时间</th>
                        <th>状态</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->username}}</td>
                        <td>{{$item->realname}}</td>
                        <td>{{$item->region ? $item->region->name : '-'}}</td>
                        <td>{{$item->isagent == 1 ? '代理' : '会员'}}</td>
                        <td>{{$item->balance}}</td>
                        <td>- <a href="#" class="btn btn-warning btn-icon-split btn-sm">
                                <span class="text">刷新</span>
                            </a>
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            {{$item->isonline == 1 ? '在线' : '离线'}}
                        </td>
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
<script>
    $('#collapseFour').addClass('show');
</script>
@endsection