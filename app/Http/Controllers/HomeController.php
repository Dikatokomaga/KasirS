<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Produk;
use App\Models\Transaksi;
use illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
  
    

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProduk = Produk::count();
        $pengguna = Auth::user()->name;
        $totalPenjualan = Transaksi::sum('total');
        

    //     $penjualanTerbanyak = DB::table('transaksi_details')
    // ->select('produk_id', DB::raw('SUM(qty) as total_qty'))
    // ->groupBy('produk_id')
    // ->orderByDesc('total_qty')
    // ->first();

// $produkTerlaris = Product::find($penjualanTerbanyak->produk_id);


        // Ambil beberapa produk terbaru (contoh, 5 produk terbaru)
        $produkTerbaru = Produk::latest()->take(2)->get();
    // dd($produkTerbaru);
        return view('layout.dashboard', compact('totalUsers', 'totalProduk', 'totalPenjualan', 'pengguna', 'produkTerbaru'));
    }

    public function dashboardp()
    {
        $totalUsers = User::count();
        $totalProduk = Produk::count();
        $pengguna = Auth::user()->name;
        $totalPenjualan = Transaksi::sum('total');
        
        // Ambil beberapa produk terbaru (contoh, 5 produk terbaru)
        $produkTerbaru = Produk::latest()->take(3)->get();
    // dd($produkTerbaru);
        return view('layout.dashboard', compact('totalUsers', 'totalProduk', 'totalPenjualan', 'pengguna', 'produkTerbaru'));
    }


    public function index(){
        $data = User::orderByRaw("FIELD(role, 'pemilik') DESC")->get();
        return view('index',compact('data'));
    }
    public function edit(Request $request, $id){ 
        $data = User::find($id);
        $user = User::find($id);
        return view('edit',compact('data','user'));
    }
    public function create(){
        return view('create');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|max:30',
            'nama'=> 'required|string',
            'role' => 'required|in:karyawan,admin,pemilik', // Pastikan rolenya adalah salah satu dari opsi yang diizinkan
            
                'password' => [
                    'required',
                    Password::min(8)
                      ->mixedCase()
                ],
            ]);
            
            if($validator->fails())
                return redirect()->back()->withErrors($validator);
            
                $data['email'] = $request->email;
                $data['name'] = $request->nama;
                $data ['role'] = $request->role;
                $data['password'] = Hash::make($request->password);

                if ($request->hasFile('gambar')) {
                    $gambar = $request->file('gambar');
                    $file_name = time(). "_".$gambar->getClientOriginalName();
                    $storage = 'images/';
                
                    // Cek apakah pemindahan gambar berhasil
                    if ($gambar->move($storage, $file_name)) {
                        $data['gambar'] = $storage . $file_name;
                    } else {
                        // Tampilkan pesan kesalahan jika pemindahan gagal
                        return redirect()->back()->withInput()->withErrors(['gambar' => 'Pemindahan gambar gagal']);
                    }
                } else {
                    // Jika gambar tidak diunggah, beri nilai default 'null'
                    $data['gambar'] = 'nul';
                }
         
                User::create($data);
                
                return redirect()->route('index');
}
public function update(Request $request, $id){
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|string|max:30',
        'nama'=> 'required|string',
        'password'=> 'nullable',
        'gambar' => 'nullable',
        ]);
        
        if($validator->fails())
            return redirect()->back()->withErrors($validator);
        
            $data['email'] = $request->email;
            $data['name'] = $request->nama;

            if($request->password){
                $data['password'] = Hash::make($request->password);
            }
            
            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $file_name = time(). "_".$gambar->getClientOriginalName();
                $storage = 'images/';
            
                // Cek apakah pemindahan gambar berhasil
                if ($gambar->move($storage, $file_name)) {
                    $data['gambar'] = $storage . $file_name;
                
            } else 
                // Jika gambar tidak diunggah, beri nilai default 'null'
                $data['gambar'] = 'kosong';
            }
            
    $request->validate([
        'role' => 'required|in:pengguna,admin,pemilik', // Sesuaikan dengan peran yang diperlukan
        // Validasi dan aturan validasi lainnya
    ]);

    $user = User::find($id);
    $user->update([
        'role' => $request->input('role'),
        // Update atribut pengguna lainnya sesuai kebutuhan
    ]);
            

            User::whereId($id)->update($data);
            $notification = array(
                'message' => 'User Berhasil Di Update',
                'alert-type' => 'success'
            );
            return redirect('admin/user')->with($notification);

}
public function delete(Request $request, $id){
    $data = User::find($id);

    if($data){
        $data->delete();
        
    }
    $notification = array(
        'message' => 'User Berhasil Di Hapus',
        'alert-type' => 'success'
    );
    
    return redirect('admin/user')->with($notification);
}

}
