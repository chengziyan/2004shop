<table border="1">
    <tr>
        <td>id</td>
        <td>姓名</td>
        <td>电子邮箱</td>
        <td>注册时间</td>
        <td>手机号</td>
        <td>登录时间</td>
        <td>登录ip</td>
        <td>操作</td>
    </tr>
    @foreach ($res as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->email}}</td>
            <td>{{date('Y-m-d H:i:s',$v->time)}}</td>
            <td>{{$v->tel}}</td>
            <td>{{date('Y-m-d H:i:s',$v->last_login)}}</td>
            <td>{{$v->login_ip}}</td>
            <td>

            </td>
        </tr>
    @endforeach
</table>
<a href="{{url('user/loginout')}}">退出</a>
