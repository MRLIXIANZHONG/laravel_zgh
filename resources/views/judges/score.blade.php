@extends('common.list')
@section('title', '专家打分')
@section("title")
@endsection
@section('header')
@endsection

@section('table')

@section('table')
    <table class="layui-table" lay-even lay-skin="nob" id="app">
        <colgroup>
            <col width="100">
            <col width="150">
            <col width="600">
        </colgroup>
        <thead>
        <tr>
            <th>活动类型</th>
            <th>数量</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($judgesScore as $item)
            <tr>
                <td>
                        @if($item->type==1)
                          月度之星
                        @endif
                        @if($item->type==2)
                            季度之星
                        @endif
                        @if($item->type==3)
                            年度之星
                        @endif
                        @if($item->type==4)
                            月度优秀五小
                        @endif
                        @if($item->type==5)
                          季度优秀五小
                        @endif
                        @if($item->type==6)
                                年度优秀五小
                        @endif
                        @if($item->type==7)
                                优秀方案
                        @endif
                </td>
                <td>{{$item->count}}</td>
                <td>
                    <a href="/admin/judges/scorelist?type={{$item->type}}" target="_self" class="layui-btn layui-btn-normal" >查看</a>
                </td>
            </tr>
        @endforeach
        @if(empty($judgesScore))
            <tr><td colspan="11" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
@endsection
@section("js")

@endsection
