<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Application;
use App\Models\Adminuser;
use App\Rules\AlphaNumCheck;
use App\Rules\PhoneCheck;
use App\Rules\MailCheck;
use DB;
use Mail;
use Session;

class IrisController extends Controller
{

    public function faq()
    {
        return view('faq');
    }

    public function faq_list()
    {
        return view('faq_list');
    }

    public function faq_regist()
    {
        return view('faq_regist');
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
