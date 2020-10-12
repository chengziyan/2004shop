<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{session('msg')}}
    @if ($errors->any())
<div class="alert alert-danger">
		<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
		</ul>
</div>
@endif
  
    <form action="{{url('user/register')}}" method="POST" >
        @csrf
        <table>
            <tr>
                <td>用户名</td>
                <td>
                    <input type="text" name="name" value="">
                </td>
            </tr>
            <tr>
                <td>邮箱</td>
                <td>
                    <input type="text" name="email" value="">
                </td>
            </tr>
            <tr>
                <td>手机号</td>
                <td>
                    <input type="text" name="tel" value="">
                </td>
            </tr>
            <tr>
                <td>密码</td>
                <td>
                    <input type="password" name="password" value="">
                </td>
            </tr>
            <tr>
                <td>确定密码</td>
                <td>
                    <input type="password" name="repwd" value="">
                </td>
            </tr>
            <tr>
                <td><input type="submit" value="注册"></td>
                <td></td>
            </tr>
        </table>
    </form>
</body>
</html>