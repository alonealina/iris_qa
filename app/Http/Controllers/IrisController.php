<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Faq;
use App\Models\Adminuser;
use DB;

class IrisController extends Controller
{

    public function faq()
    {
        $faq_list = Faq::orderBy('id', 'asc')->get();
        return view('faq', [
            'faq_list' => $faq_list,
        ]);
    }

    public function faq_list()
    {
        $faq_list = Faq::orderBy('id', 'asc')->get();
        return view('faq_list', [
            'faq_list' => $faq_list,
        ]);
    }

    public function faq_regist()
    {
        return view('faq_regist');
    }

    public function faq_store(Request $request)
    {
        $rules = [
            'question' => ['required', 'max:50'],
            'answer' => 'required',
        ];

        $messages = [
            'question.required' => '質問を入力してください',
            'question.required' => '質問は50文字以内で入力してください',
            'answer.required' => '内容を入力してください',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $faq = new Faq();

        $request = $request->all();
        $fill_data = [
            'question' => $request['question'],
            'answer' => $request['answer'],
        ];

        DB::beginTransaction();
        try {
            $faq->fill($fill_data)->save();
            DB::commit();
            return redirect()->to('admin/faq_list');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function faq_edit($id)
    {
        $faq = Faq::find($id);

        return view('faq_edit', [
            'faq' => $faq,
        ]);
    }

    public function faq_update(Request $request)
    {
        $rules = [
            'question' => ['required', 'max:50'],
            'answer' => 'required',
        ];

        $messages = [
            'question.required' => '質問を入力してください',
            'question.required' => '質問は50文字以内で入力してください',
            'answer.required' => '内容を入力してください',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $faq = Faq::find($request['id']);
        $request = $request->all();
        $fill_data = [
            'question' => $request['question'],
            'answer' => $request['answer'],
        ];

        DB::beginTransaction();
        try {
            $faq->update($fill_data);

            DB::commit();
            return redirect()->to('admin/faq_list');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function faq_delete($id)
    {
        DB::beginTransaction();
        try {
            Faq::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('admin.faq_list')->with('message', 'FAQを削除しました');
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    public function login_admin(Request $request)
    {
        $admin_user = Adminuser::where('login_id', $request->login_id)->first();
        if (isset($admin_user)) {
            if ($request->password == $admin_user->password) {
                // セッション
                session(['login_id' => $admin_user->login_id]);
                return redirect('admin/faq_list'); 
            }
        }

        return redirect('admin/login')->with(['login_error' => 1]);
    }
    
    public function logout_admin()
    {
        session()->forget('login_id');
        return redirect('admin/login');
    }


}
