<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductGalleryRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;


class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            // memanggil dengan relasinya
            $query = ProductGallery::with(['product']);

            return Datatables::of($query)
            ->addColumn('action', function($item){
                return '
                    <div class="btn btn-group">
                        <div class="btn btn-dropdown">
                            <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                Aksi
                            </button>
                            <div class="dropdown-menu">
                                <form action="'.route('product-gallery.destroy',$item->id).'" method="POST">
                                    '. method_field('delete') . csrf_field() .'
                                    <button type="submit" class="dropdown-item text-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                ';
            })
            ->editColumn('photos',function($item){
                return $item->photos ? '<img src="'.Storage::url($item->photos).'" style="max-height: 80px;" />' : '';
            })
            ->rawColumns(['action','photos'])
            ->make();
        }
        return view('pages.admin.product-gallery.index');
    }

    
    public function create()
    {
        $products = Product::all();
        // $categories = Category::all();
        return view('pages.admin.product-gallery.create',[
            'products' => $products
        ]);
    }

    public function store(ProductGalleryRequest $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/product','public');

        ProductGallery::create($data);

        return redirect()->route('product-gallery.index');
    }


    public function show($id)
    {
        //
    }

    
    // public function edit($id)
    // {

    // }


    // public function update(ProductRequest $request, $id)
    // {
        
    // }

    
    public function destroy($id)
    {
        $item = ProductGallery::findOrFail($id);

        $item->delete();

        return redirect()->route('product-gallery.index');
    }
}
