<?php
/**
 * Created by IntelliJ IDEA.
 * User: bilguun
 * Date: 1/6/18
 * Time: 6:17 PM
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends TController
{

    public function users(Request $request){
//        $validatedData = $request->validate([
//            'page' => ['min:1']
//        ]);
        $page = 1;
        $order_by = 'id';
        $order_type = 'asc';
        $search_col = null;
        $search_val = null;
        $search_operator = null;
        $item_per_page = 10;
        if($request->has('page')){
            $page = $request->input('page');
        }
        if($request->has('item_per_page')){
            $item_per_page = $request->input('item_per_page');
        }
        if($request->has('search_col')){
            $search_col = $request->input('search_col');
            if($request->has('search_val')){
                $search_val = $request->input('search_val');
                if($request->has('search_operator')){
                    $search_operator = $request->input('search_operator');
                }
            }
        }
        if($request->has('order_by')){
            $order_by = $request->input('order_by');
        }
        if($request->has('order_type')){
            $order_type = $request->input('order_type');
        }
        $audios = User::orderBy($order_by, $order_type);
        if($search_col != null && $search_val != null){
            if($search_operator != null){
                $audios->where($search_col, $search_operator, $search_val);
            }
            else {
                $audios->where($search_col, $search_val);
            }
        }
        $result = $audios->get();

        $offset = $item_per_page * ($page-1);
        $filtered = $result->slice($offset, $item_per_page);
        $total_rows = $result->count();
        return view('transcription.users',
            [
                'users' => $filtered,
                'row_from' => $offset+1,
                'row_to' => $offset + $result->count(),
                'page' => $page,
                'results' => $result->count(),
                'total_page' => ceil($total_rows/$item_per_page),
                'total_rows' => $total_rows,
                'request' => $request,
                'item_per_page' => $item_per_page
            ]);
    }

    public function usersUpdate(Request $request) {
        $request->validate(['user' => 'required']);
        $user = User::find($request->input('user'));
        if($user != null){
            if($request->has('ban')){
                $user->status = 0;
                $user->save();
                return redirect(url()->previous())->with('msg', $user->name . ' нэртэй хэрэглэгчийг хориглолоо.');
            }
            elseif($request->has('unban')){
                $user->status = 1;
                $user->save();
                return redirect(url()->previous())->with('msg', $user->name . ' нэртэй хэрэглэгчийн хориог гаргалаа.');
            }
            elseif($request->has('promote')){
                $user->isAdmin = true;
                $user->save();
                return redirect(url()->previous())->with('msg', $user->name . ' нэртэй хэрэглэгчид админ эрх олголоо.');
            }
            elseif($request->has('demote')){
                $user->isAdmin = false;
                $user->save();
                return redirect(url()->previous())->with('msg', $user->name . ' нэртэй хэрэглэгчийн админ эрхийг хураалаа.');
            }
            return redirect(url()->previous())->withErrors('Үйлдэл тодорхойгүй!');
        }
        return redirect(url()->previous())->withErrors('Хэрэглэгч олдсонгүй!');
    }

}