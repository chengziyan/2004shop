<table border=1>
    <tr>
        <td>id</td>
        <td>用户名</td>
        <td>邮箱账号</td>
        <td>注册时间</td>
        <td>最后登录时间</td>
        <td>操作</td>
    </tr>
    @foreach($res as $v)
    <tr>
        <td>{{$v->uid}}</td>
        <td>{{$v->user_name}}</td>
        <td>{{$v->email}}</td>
        <td>{{date('Y-m-d',$v->reg_time)}}</td>
        <td>{{date('Y-m-d',$v->last_login)}}</td>
        <td>
        <a href="{{url('delete/'.$v->uid)}}">删除</a>
        <a href="{{url('edit/'.$v->uid)}}">修改</a>
        </td>
    </tr>
    @endforeach
</table>
