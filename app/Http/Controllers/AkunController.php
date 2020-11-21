<?php

namespace App\Http\Controllers;
use App\Models\akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AkunController extends Controller
{
    //

    public function index()
    {
        $akuns = akun::latest()->paginate(10);
        return view('akun.index', compact('akuns'));
    }

    public function create()
    {
        return view('akun.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username'     => 'required',
            'password'   => 'required',
            'image'     => 'required|image|mimes:png,jpg,jpeg'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/images', $image->hashName());

        $akun = akun::create([
            'username'     => $request->username,
            'password'   => $request->password,
            'image'     => $image->hashName()
        ]);

        if($akun){
            //redirect dengan pesan sukses
            return redirect()->route('akun.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('akun.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(akun $akun)
    {
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, akun $akun)
    {
        $this->validate($request, [
            'username'     => 'required',
            'password'   => 'required',
            'image'     => 'required|image|mimes:png,jpg,jpeg'
        ]);

        //get data akun by ID
        $akun = akun::findOrFail($akun->id);

        if($request->file('image') == "") {

            $akun->update([
                'username'     => $request->username,
                'password'   => $request->password
            ]);
    
        } else {
    
            //hapus old image
            Storage::disk('local')->delete('public/images/'.$akun->image);
    
            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/images', $image->hashName());
    
            $akun->update([
                'username'     => $request->username,
                'password'   => $request->password,
                'image'     => $image->hashName()
            ]);
    
        }

        if($akun){
            //redirect dengan pesan sukses
            return redirect()->route('akun.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('akun.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $akun = akun::findOrFail($id);
        Storage::disk('local')->delete('public/images/'.$akun->image);
        $akun->delete();

        if($akun){
            //redirect dengan pesan sukses
            return redirect()->route('akun.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('akun.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
