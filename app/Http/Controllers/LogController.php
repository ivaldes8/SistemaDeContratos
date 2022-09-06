<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {

        $query = Logs::query();

        $query->when(request()->input('user_id'), function ($q) {
            return $q->where('user_id', request()->input('user_id'));
        });

        $query->when(request()->input('type'), function ($q) {
            return $q->where('type', request()->input('type'));
        });

        $query->when(request()->input('action'), function ($q) {
            return $q->where('action', request()->input('action'));
        });


        $query->when(request()->input('fechaFrom'), function ($q) {
            return $q->whereDate('created_at', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaFrom'))->toDateString());
        });

        $query->when(request()->input('fechaTo'), function ($q) {
            return $q->whereDate('created_at', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaTo'))->toDateString());
        });

        $logs = $query->orderBy('id', 'desc')->paginate(50);

        $actions = ["create", "edit", "delete"];
        $types = ["CM", "CMF", "CP", "CPF", "CE", "supCM", "supCE", "supCP"];
        $users = User::all();

        return view('logs.index', compact('logs', 'types', 'actions', 'users'));
    }

    public function delete()
    {
        return view('logs.delete');
    }

    public function destroy()
    {
        Logs::truncate();
        return redirect()->back()->with('status', 'Logs eliminados Satisfactoriamente');
    }
}
