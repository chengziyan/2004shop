<?php
namespace App\Http\Controllers;
use App\Http\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Foundation\Console\Presets\React;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redis;
class UserController extends Controller
{
    //添加视图
    function create(){
        return view('user/create');
    }
    //注册方法
    function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:user',
            'password' => 'required',
            'email' => 'required|unique:user',
            'tel' => 'required|unique:user',
        ],[
                'name.required'=>'用户名称必填',
                'name.unique'=>'用户已存在',
                'password.required'=>'密码必填',
                'email.required'=>'邮箱必填',
                'email.unique'=>'邮箱已存在',
                'tel.required'=>'手机号必填',
                'tel.unique'=>'手机号已存在',
        ]);
        //表单验证
        if($validator->fails()){
            return redirect('/user/create')
            ->withErrors($validator)
            ->withInput();
        }
        $data=$request->except('_token');

        if($data['password']!=$data['repwd']){
            return redirect('user/create')->with('msg','两次密码不一致');
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['last_login']=$_SERVER['REMOTE_ADDR'];
        $data['time']=time();
        unset($data['repwd']);
        $res=UserModel::insert($data);
        if($res){
            return redirect('user/login');
        }
    }
    //登录展示
    function index(){
        $res=UserModel::all();
        // dd($res);
        return view('user/index',['res'=>$res]);
    }
    function login(){
        return view('user/login');
    }
    //登录方法
    function logindo(Request $request){
        $post=$request->except('_token');
        //dd($post);
        $add=$_SERVER['REMOTE_ADDR'];
        $reg='/^1[3|4|5|6|7|8|9]\d{9}$/';
        $reg_email='/^\w{3,}@([a-z]{2,7}|[0-9]{3})\.(com|cn)$/';
        if(preg_match($reg,$post['name'])){
            $where=[
                ['tel',"=",$post['name']]
            ];
        }else if(preg_match($reg_email,$post['name'])){
            $where=[
                ['email',"=",$post['name']]
            ];
        }else{
            $where=[
                ['name',"=",$post['name']]
            ];
        }
        $user = UserModel::where($where)->first();
        //判断
        $count=Redis::get($user->id);
        //$login_time = ceil(Redis::TTL("login_time:".$user->id) / 60);
        $out_time=(ceil((Redis::TTL($user->id)/60)));
            //判断错误次数
            if($count>=5){
                    return redirect('/user/login')->with('msg','密码错误次数过多,请'.$out_time.'分钟后在来');
            }
        if(!$user){
            return redirect('/user/login')->with('msg','用户不存在');
        }
        if(!password_verify($post['password'], $user['password'])){
            //用redis自增记录错误次数
            Redis::incr($user->id);
            $count=Redis::get($user->id);
            //判断错误次数
            if($count>=5){
                Redis::SETEX($user->id,60*60,5);
                    return redirect('/user/login')->with('msg','密码错误次数过多,请一个小时候在来');
            }
            return redirect('/user/login')->with('msg','密码错误'.$count.'次，五次后锁定一小时');
        }
        $data=[
            'last_login'=>time(),
            'login_ip'=>$add
        ];
        $res = UserModel::where('id',$user['id'])->update($data);
        session(['login'=>$user]);
            return redirect('/user/index');
    }
    function loginout(){
        session(['login'=>null]);
        return redirect('/user/login');
    }
}
