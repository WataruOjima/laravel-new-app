<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UserRequest;
use App\User; 
use Hash;

class UserController extends Controller
{
   /**
    * ログインフォーム表示アクション
    */
  public function signin()
  {
   return view('user.signin');
  }

   /**
    * ログイン処理アクション
    */
  public function login(UserRequest $request)
  {
    $email    = $request->input('email');
    $password = $request->input('password');
    if (!Auth::attempt(['email' => $email, 'password' => $password])) {
    // 認証失敗
      return redirect('/')->with('error_message', 'ログインに失敗しました！');
    }
    // 認証成功
    return redirect()->route('bbs.index')->with('poststatus', 'ウェルカムバック！');
    }

   /**
    * ログアウト処理アクション
    */
    public function logout()
    {
    Auth::logout();
    return redirect()->route('user.signin');
    #->with('flash_message', 'またね！');
    }

   /**
    * ユーザ登録ページ表示アクション
    */
    public function create()
    {
        return view('user.create');
    }

   /**
    * ユーザ登録処理アクション
    */
    public function store(UserRequest $request)
    {
    $user     = new User;
    $name     = $request->input('name');
    $email    = $request->input('email');
    $password = $request->input('password');
    $params   = [
      'name'      => $name,
      'email'     => $email,
      'password'  => Hash::make($password),
    ];
    if (!$user->userSave($params)) {
        return redirect()->route('user.create')->with('error_message', 'ユーザー登録に失敗しました');
    }
    if (!Auth::attempt(['email' => $email, 'password' => $password])) {
      return redirect()->route('user.signin')->with('error_message', 'ログインに失敗しました！');
    }
    return redirect()->route('bbs.index')->with('poststatus', 'ようこそ！Biborokuへ');
    }
   /**
    * ユーザ登録/更新
    */
    public function userSave($params)
    {
     $isRegist = $this->fill($params)->save();
     return $isRegist;
    }

   /**
    * ユーザ編集表示アクション
    */
    public function edit($id)
    {
    $user       = User::find($id);
    $viewParams = [
      'user' => $user,
    ];
    $this->authorize('view', $user);
    $this->authorize('edit', $user);
    return view('user.edit', $viewParams);
    }

   /**
    * ユーザ更新アクション
    */
    public function update(UserRequest $request, $id)
    {
        $user     = User::find($id);
        $name     = $request->input('name');
        $email    = $request->input('email');
        $password = $request->input('password');
        $params   = [
          'name'      => $name,
          'email'     => $email,
          'password'  => Hash::make($password),
        ];
        $this->authorize('update', $user);
        if (!$user->userSave($params)) {
          // 更新失敗
          return redirect()
                 ->route('user.edit', ['user' => $user->id])
                 ->with('error_message', 'アップデート失敗');
        }
        return redirect()->route('bbs.index')->with('flash_message', 'アップデート完了!');
    }

  /**
   * ユーザ一覧表示アクション
   */
   public function index()
   {
    $users = User::all();
    $viewParams = [
      'users' => $users,
    ];
    return view('user.index', $viewParams);
   }

  /**
   * ユーザ削除処理アクション
   */
  public function destroy($id)
  {
    $this->adminCheck();
    $user = User::find($id);
    if (!$user->delete()) {
      return redirect()->route('user.index')->with('error_message', '削除失敗しました');
    }
    return redirect()->route('user.index')->with('flash_message', '削除しました');
  }

  // private
  // ログインユーザが管理者であるかチェック
  private function adminCheck()
  {
    $adminFlg = Auth::user()->admin_flg;
    if (!$adminFlg) {
      abort(404);
    }
    return true;
  }

}
