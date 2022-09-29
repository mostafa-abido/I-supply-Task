<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Enumerations\ProductType;

use App\Models\Product;
use Illuminate\Http\Request;

use DB;

class ProductsController extends Controller
{

    public function index()
    {
        $product = Product::orderBy('id','DESC') -> paginate(PAGINATION_COUNT);
        return view('usr.products.index', compact('product'));
    }

    public function create()
    {
        $product =   Product::select('id','parent_id')->get();
        return view('usr.products.create',compact('product'));
    }

    public function store(Request $request)
    {

        try {

            DB::beginTransaction();    

            $product = Product::create($request->except('_token'));           
            $product->name = $request->name;
            $product->save();

            return redirect()->route('user.products')->with(['success' => 'تم ألاضافة بنجاح']);
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('user.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }

    public function edit($id)
    {
           //get specific categories and its translations
           $products = Product::orderBy('id', 'DESC')->find($id);

        if (!$product)
            return redirect('user.products')->with(['error' => 'هذا القسم غير موجود']);

        return view('user.products.edit',compact('product')) ;
        }


        public function update($id, Request $request)
        {
            try {
    
                //update DB
    
    
                $products = Product::find($id);
    
                if (!$product)
                    return redirect()->route('user.products')->with(['error' => 'هذا القسم غير موجود']);
    
                if (!$request->has('is_active'))
                    $request->request->add(['is_active' => 0]);
                else
                    $request->request->add(['is_active' => 1]);
    
                $product->update($request->all());
    
                //save translations
                $product->name = $request->name;
                $product->save();
    
                return redirect()->route('user.products')->with(['success' => 'تم ألتحديث بنجاح']);
            } catch (\Exception $ex) {
    
                return redirect()->route('user.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
    
        }

     // delete method //
        public function destroy($id)
        {
    
            try {
                //get specific categories and its translations
                $product = Product::orderBy('id', 'DESC')->find($id);
    
                if (!$product)
                    return redirect()->route('user.products')->with(['error' => 'هذا القسم غير موجود ']);
    
                $product->delete();
    
                return redirect()->route('user.products')->with(['success' => 'تم  الحذف بنجاح']);
    
            } catch (\Exception $ex) {
                return redirect()->route('user.products')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            }
        }
    
    
}