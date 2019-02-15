<?php
namespace App\Http\Controllers\API;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    /**
     * users api
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::all();
        return response()->json(['users' => $users], $this-> successStatus);
    }

    /**
     * say hi api
     *
     * @return \Illuminate\Http\Response
     */
    public function sayhi(Request $request)
    {
        $user = Auth::user();
        $to = $request->input('to');

        $message = new Message();
        $message->from = $user->getAuthIdentifier();
        $message->to = $to;
        $message->text = 'Hi';
        $message->save();

        return response()->json(['message' => $message], $this-> successStatus);
    }

    /**
     * get messages api
     *
     * @return \Illuminate\Http\Response
     */
    public function getMessages(Request $request)
    {

        $user = Auth::user();

        $messages = Message::where('to', $user->getAuthIdentifier())
            ->with('fromUser')
            ->get();

        return response()->json(['messages' => $messages], $this-> successStatus);
    }
}
