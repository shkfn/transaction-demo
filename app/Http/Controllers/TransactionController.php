<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputRequest;
use App\Models\Post;
use Shkfn\TransactionParameter\Transaction;

class TransactionController extends Controller
{
    /** @var Transaction */
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        return redirect(route('input'));
    }

    /**
     * 入力画面表示
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input($token = null)
    {
        $params = null;
        if (is_null($token)) {
            $token = $this->transaction->start(); // tokenがnullか引数無しの場合に新しいtokenを発行して返却
        } else {
            // token付きで入力画面に戻ってきた場合にパラメータを引き出せる
            if ($this->transaction->start($token)) { // tokenが渡された場合は保存領域でtokenの存在確認をbool返却
                $params = $this->transaction->get(); // パラメータ取得。格納値が無い場合は空配列が返る。
            } else {
                return abort(404);
            }
        }
        return view('input', ['token' => $token,'params' => $params]); // tokenはルートパラメータとして使用
    }

    /**
     * 入力バリデーション
     * @param InputRequest $request
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function validateInput(InputRequest $request, $token)
    {
        // token毎に区切られた領域に保存
        if ($this->transaction->start($token)) {
            $params = $request->validated();
            $this->transaction->put($params); // バリデーション済みの値を保存。第2引数に文字列でタグを設定可能。タグを設定して保存した場合は、get時にもタグの指定が必要。
            return redirect(route('confirm', ['token' => $token]));
        }
        return back();
    }

    /**
     * 確認画面表示
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function confirm($token)
    {
        if ($this->transaction->start($token)) { // tokenを使ってトランザクションを再開
            $params = $this->transaction->get();
            return view('confirm', ['token' => $token, 'params' => $params]);
        }
        return redirect(route('input')); // 入力画面やエラー画面等へリダイレクト
    }

    /**
     * 登録処理
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register($token)
    {
        if ($this->transaction->start($token)) { // tokenを使ってトランザクションを再開
            $params = $this->transaction->get();
            Post::create($params); // DB登録
            $this->transaction->close(); // tokenの保存領域を明示的にクリアするメソッド
            return redirect(route('complete'));
        }
        return redirect(redirect('input')); // 入力画面やエラー画面等へリダイレクト
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function complete()
    {
        return view('complete');
    }
}
