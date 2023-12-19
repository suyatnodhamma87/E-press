<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function index (Request $request) {
        $divisi = DB::table('divisi')->orderBy('kode_div')->get();
        $role = DB::table('roles')->orderBy('id')->get();
        $query = User::query();
        $query->select('users.id', 'users.name', 'email', 'nama_div', 'roles.name as role');
        $query->join('divisi', 'users.kode_div', '=', 'divisi.kode_div');
        $query->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id');
        $query->join('roles', 'model_has_roles.role_id', '=', 'roles.id');
        if(!empty($request->name)){
            $query->where('users.name', 'like', '%'. $request->name . '%');
        }
        $users = $query->paginate(10);
        $users->appends(request()->all());
        return view('user.index', compact ('users', 'divisi', 'role'));
    }

    public function store (Request $request) {
        $nama_user = $request->nama_user;
        $email = $request->email;
        $kode_div = $request->kode_div;
        $role = $request->role;
        $password = bcrypt($request->password);

        DB::beginTransaction();
        try {
            //simpan data user dengan role
            $user = User::create ([
                'name' => $nama_user,
                'email' => $email,
                'kode_div' => $kode_div,
                'password' => $password
            ]);

            $user->assignRole($role);
            DB::commit();
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        } catch (Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data gagal disimpan']);

        }
    }
    public function edit (Request $request) {
        $id_user = $request->id_user;
        $divisi = DB::table('divisi')->orderBy('kode_div')->get();
        $role = DB::table('roles')->orderBy('id')->get();
        $user = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('id', $id_user)->first();

        return view('setting.edituser', compact ('divisi', 'role', 'user'));
    }

    public function update (Request $request, $id_user) {
        $nama_user = $request->nama_user;
        $email = $request->email;
        $kode_div = $request->kode_div;
        $role = $request->role;
        $password = bcrypt($request->password);

       if(isset($request->password)) {
        $data = [
            'name' => $nama_user,
            'email' => $email,
            'kode_div' => $kode_div,
            'password' => $password
        ];
       } else {
        $data = [
            'name' => $nama_user,
            'email' => $email,
            'kode_div' => $kode_div,
        ];
       }

       DB::beginTransaction();
       try {
            //update data user
            DB::table('users')->where('id', $id_user)
            ->update($data);

            //update data role
            DB::table('model_has_roles')->where('model_id', $id_user)
            ->update([
                'role_id' => $role
            ]);

            DB::commit();
            return Redirect::back()->with(['success'=>'Data berhasil diupdate']);
       } catch (Exception $e) {

            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data gagal diupdate']);
       }
    }

    public function deleteuser ($id_user) {
        try {
            DB::table('users')->where('id', $id_user)->delete();
            return Redirect::back()->with(['success' => 'User berhasil dihapus!']);
        } catch (Exception $e) {
            return Redirect::back()->with(['error' => 'User gagal dihapus!']);
        }
    }
}
