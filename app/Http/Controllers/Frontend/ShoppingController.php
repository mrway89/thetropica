<?php

namespace App\Http\Controllers\Frontend;

use App\Category;
use App\Feature;
use App\Image;
use App\Origin;
use App\Post;
use App\Product;
use App\ProductBrand;
use App\UserServiceProvider;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ShoppingController extends CoreController
{
    private $paginateCount   = 12;

    public function __construct()
    {
        parent::__construct();
    }

    public function productBrand()
    {
        $brands               = ProductBrand::get();
        $this->data['brands'] = $brands;

        $this->data['content'] = Image::where('type', 'product_prologue')->first();

        $this->data['count'] = $brandGroupCount;

        // SEO
        $this->data['head_title']       = $this->data['product_title'];
        $this->data['head_meta_title']  = $this->data['product_meta_title'];
        $this->data['head_description'] = $this->data['product_description'];
        $this->data['head_keyword']     = $this->data['product_keywords'];

        return $this->renderView('frontend.pages.product');
    }

    public function purchase(Request $request)
    {
        $products  = Product::with('review', 'cover')->where('is_active', 1)->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();

        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;

        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);

            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;

                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }

            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }

        $allFeatures    = DB::table('products')->pluck('tags');

        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
		
		$origins_v = DB::select("SELECT *  FROM `origins` ORDER BY name ASC");

		foreach($origins_v as $raws){
			$tags_v = DB::select("SELECT DISTINCT(tags) FROM `products` WHERE `is_active` = '1' AND origin_id='$raws->id' AND tags !=''");
				 
			 $data_trv[] = array(
				'og_id'   => $raws->id,
				'og_name' => $raws->name,
				'dtv'     => $tags_v 
			 ); 
		}
		
		
		$this->data['org_in'] = $data_trv;
		
		
		/* foreach($data_trv as $rt => $org_ins){
		     echo $org_ins['og_name'];
			 echo "<br />";
			 foreach($org_ins['dtv'] as $dt){
				 echo $dt->tags;
				 echo "<br />"; 
			 } 
			 
			 echo "<hr />"; 
		}  */
		
		  /* print_r("<pre>");
		print_r($data_trv); 
		die(); */
		
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);

        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
		
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];

       //accordion menu link
       $this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->orderBy('sorting', 'ASC')->get();

        return $this->renderView('frontend.product.product_list');
    }

    public function searchProduct(Request $request)
    {
        $products   = Product::with('review', 'cover')->where('is_active', 1)->filterProduct();
        $items      = Product::where('is_active', 1)->get();
        $brands     = ProductBrand::orderBy('name', 'ASC')->get();

        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;

        $searchItem = $items->filter(function ($model) use ($request) {
            return false !== stristr($model->full_name, $request->search);
        });

        $selectedItems = $searchItem->pluck('id')->toArray();
        $products      = $products->whereIn('id', $selectedItems);

        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            if ($sort == 3) {
                $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                $arrP          = implode(',', $tempP);
                $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
            } elseif ($sort == 4) {
                $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                $arrP          = implode(',', $tempP);
                $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
            } else {
                $products = $products->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
            }

            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
        }

        $allFeatures    = DB::table('products')->pluck('tags');

        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);

        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;

        return $this->renderView('frontend.pages.search_result');
    }

    public function productDetail($slug)
    {
        $product    = Product::with(['otherProducts', 'certifications' => function ($q) {
            $q->orderBy('sorting', 'ASC');
        }])->where('slug', $slug)->firstOrFail();

        if (!$product) {
            abort(404);
        }

        $product->view++;
        $product->save();

        $sku       = explode('-', $product->sku)[0];
        $relates   = Product::where('sku', 'LIKE', '%' . $sku . '%')->where('is_active', 1)
            // ->where('name', '!=', $product->name)
            // ->where('brand_id', $product->brand_id)
            ->orderBy('id', 'asc')->groupBy('name')->pluck('id')->toArray();

        $index = array_search($product->id, $relates);
        if ($index !== false && $index > 0) {
            $prev = $relates[$index - 1];
        }
        if ($index !== false && $index < count($relates) - 1) {
            $next = $relates[$index + 1];
        }
        // dd($product->id);

        $related =  Product::find($next);
        if (!$related) {
            $first   = array_values($relates)[0];
            $related =  Product::find($first);
        }

        // $tags      = explode(',', str_replace(' ', '', strtolower($product->tags)));

        // foreach ($tags as $key => $value) {
        //     if ($key == 0) {
        //         $related   = $related->where('tags', 'LIKE', '%' . $value . '%');
        //     } else {
        //         $related   = $related->orWhere('tags', 'LIKE', '%' . $value . '%');
        //     }
        // }
        // $related             = $related->get();

        // $selected= [];
        // foreach ($related as $key => $item) {
        //     if ($item->id !== $product->id) {
        //         if ($item->category_id == $product->category_id) {
        //             $selected[] = $related->pull($key);
        //         }
        //     }
        // }
        // $selected = array_slice($selected, 0, 3);

        // dd($related);
        $this->data['product']        = $product;
        $this->data['related']        = $related;
        // SEO
        $this->data['head_title']       = $product->name;
        $this->data['head_meta_title']  = $product->name;
        $this->data['head_description'] = str_limit(strip_tags($product->description_id), $limit = 150, $end = '...');
        $this->data['head_keyword']     = $this->data['default_keywords'];
        $this->data['head_image']       = asset($product->cover->url);
        //product variant
	$this->data['product_variant'] = DB::table('product_relateds')->where('product_id', $product->id)->get();
	$this->data['default_variant'] = $product->product_weight;
        $this->data['default_unit'] = $product->unit;

        return $this->renderView('frontend.product.product_detail');
    }

    private function getProducts($request, $categories, $param, $type)
    {
        $brands         = $request->p;
        $price          = $request->c;
        $sort           = $request->s;
        $feats          = $request->f;

        $products  = Product::with('review', 'cover')->where('is_active', 1);

        if ($param == 1) {
            $grandchilds = [];

            foreach ($categories->childs as $key => $value) {
                $childrens = $value->childs->pluck('id');
                array_push($grandchilds, $childrens);
            }

            $products       = $products->whereIn('category_id', array_flatten($grandchilds));
            $allBrands      = Product::whereIn('category_id', array_flatten($grandchilds))->groupBy('brand_id')->get()->pluck('brand_id');
            $type           = $categories->id == 4 ? 'eproduct' : 'product';
        } elseif ($param == 2) {
            $subcategories  = Category::where('parent_id', $categories->id)->get()->pluck('id');
            $products       = $products->whereIn('category_id', $subcategories);
            $allBrands      = Product::whereIn('category_id', $subcategories)->groupBy('brand_id')->get()->pluck('brand_id');
            $allFeatures    = Product::whereIn('category_id', $subcategories)->get()->pluck('features');

            $type = $categories->parent->id == 4 ? 'eproduct' : 'product';
        } elseif ($param == 3) {
            $allBrands        = Product::where('category_id', $categories->id)->groupBy('brand_id')->get()->pluck('brand_id');
            $products         = $products->where('category_id', $categories->id);
            $allFeatures      = Product::where('category_id', $categories->id)->get()->pluck('features');
            $type             = $categories->parent->parent->id == 4 ? 'eproduct' : 'product';
        }
        if ($type == 'eproduct') {
            $products         = $products->whereHas('Ticket', function ($query) {
                $query->where('start_sale', '<=', \Carbon\Carbon::now())
                    ->where('end_sale', '>=', \Carbon\Carbon::now());
            });
        }

        $realbrand = $brands->id;

        if ($brand || $price || $sort || $feats) {
            if ($brands) {
                $brands = explode(',', $brands);

                $this->data['filterbrands']   = $brands;

                $products   = $products->whereIn('brand_id', $brands);
            }

            if ($price) {
                $price                    = explode(',', $price);
                $pricebot                 = $price[0];
                $pricetop                 = $price[1];
                if ($price[0] > 0 && $price[1] > 0) {
                    $products = $products->where(function ($query) use ($pricebot, $pricetop) {
                        $query->wherebetween('price', [$pricebot, $pricetop])
                            ->orWhereBetween('discounted_price', [$pricebot, $pricetop]);
                    });
                } else {
                    if ($price[0] > 0) {
                        $products = $products->where(function ($query) use ($pricebot) {
                            $query->where('price', '>=', $pricebot)
                                ->orWhere('discounted_price', '>=', $pricebot);
                        });
                    }
                    if ($price[1] > 0) {
                        $products = $products->where(function ($query) use ($pricetop) {
                            $query->where('price', '<=', $pricetop)
                                ->orWhere('discounted_price', '<=', $pricetop);
                        });
                    }
                }

                $this->data['lowerprice'] = $price[0];
                $this->data['upperprice'] = $price[1];
            }

            if ($sort) {
                switch ($sort) {
                    case '1':
                        $products = $products->orderBy('created_at', 'DESC');
                        break;
                    case '2':
                        $products = $products->orderBy('created_at', 'ASC');
                        break;
                    case '3':
                        $products = $products->orderBy('name', 'ASC');
                        break;
                    case '4':
                        $products = $products->orderBy('name', 'DESC');
                        break;
                    case '5':
                        $products = $products->orderBy('price', 'ASC');
                        break;
                    case '6':
                        $products = $products->orderBy('price', 'DESC');
                        break;
                    default:
                        $products = $products->orderBy('created_at', 'DESC');
                        break;
                }
                $this->data['filtersort']   = $sort;
            }

            if ($feats) {
                $feats = explode(',', $feats);

                $this->data['filterfeature']   = $feats;
                // $tempFeats                     = [];
                foreach ($feats as $i => $f) {
                    if ($i == 0) {
                        $products = $products->where('features', '=', $f);
                    } else {
                        $products = $products->orWhere('features', '=', $f);
                    }
                }
            }

            // if ($price[0] && $price[1]) {
            //     $products         = $products;
            // } else {
            //     if ($price[0]) {
            //         // $products                 = $products->where('price', '>=', $price[0])->orWhere('discounted_price', '>=', $price[0]);
            //         $productss                 = $products->filter(function ($item) {
            //             return $item->priceCurrent >= $price[0];
            //         });
            //     }
            //     if ($price[1]) {
            //         $productss = $products->filter(function ($item) {
            //             return $item->price <= $price[1];
            //         });
            //     }
            //     $products        = $productss;
            // }

            $products = $products->paginate($this->paginateCount);
        } else {
            $products       = $products->orderBy('created_at', 'DESC')->paginate($this->paginateCount);
        }

        $brands     = ProductBrand::whereIn('id', $allBrands)->get();

        if ($param !== 1) {
            $features = [];
            foreach ($allFeatures as $feat) {
                if ($feat) {
                    $featuresArray = explode(',', str_replace(' ', '', $feat));
                    foreach ($featuresArray as $singleFeature) {
                        array_push($features, $singleFeature);
                    }
                }
            }
            $productFeatures                = Feature::whereIn('name', $features)->orderBy('name', 'asc')->get();
            $this->data['features']         = $productFeatures;
        }

        $this->data['products']         = $products;
        $this->data['sorts']            = $this->productsorts;
        $this->data['brands']           = $brands;

        return $this->data;
    }

    private function getSearchResults($request, $products, $param)
    {
        $brands         = $request->p;
        $price          = $request->c;
        $sort           = $request->s;
        $category       = $request->x;

        $realcategory = $products->pluck('category_id', 'category_id');
        $allBrands    = $products->pluck('brand_id', 'brand_id');

        if ($category || $price || $sort || $brands) {
            if ($category) {
                $category = explode(',', $category);

                $this->data['filtercategory']   = $category;

                $products       = $products->whereIn('category_id', $category);
            }

            if ($price) {
                // dd($products->get());
                $price                    = explode(',', $price);
                if ($price[0]) {
                    $products = $products->where('price', '>=', $price[0]);
                }

                if ($price[1]) {
                    $products = $products->where('price', '<=', $price[1]);
                }

                $this->data['lowerprice'] = $price[0];
                $this->data['upperprice'] = $price[1];
            }

            if ($sort) {
                switch ($sort) {
                    case '1':
                        $products = $products->orderBy('created_at', 'DESC');
                        break;
                    case '2':
                        $products = $products->orderBy('created_at', 'ASC');
                        break;
                    case '3':
                        $products = $products->orderBy('name', 'ASC');
                        break;
                    case '4':
                        $products = $products->orderBy('name', 'DESC');
                        break;
                    case '5':
                        $products = $products->orderBy('price', 'ASC');
                        break;
                    case '6':
                        $products = $products->orderBy('price', 'DESC');
                        break;
                    default:
                        $products = $products->orderBy('created_at', 'DESC');
                        break;
                }
                $this->data['filtersort']   = $sort;
            }

            if ($brands) {
                // dd($brands);
                $brands = explode(',', $brands);

                $this->data['filterbrands']   = $brands;

                $products   = $products->whereIn('brand_id', $brands);
            }

            $products = $products->paginate($this->paginateCount);
        } else {
            $products       = $products->orderBy('created_at', 'DESC')->paginate($this->paginateCount);
        }

        if (empty($realcategory)) {
            $tempCategory               = [];
            $this->data['searching']    = $request->search;
        } else {
            $allCategories = Category::whereIn('id', $realcategory)->get();
        }

        $brands = ProductBrand::whereIn('id', $allBrands)->get();

        $this->data['sorts']            = $this->productsorts;
        $this->data['brands']           = $brands;
        $this->data['categories']       = $allCategories;
        $this->data['products']         = $products;
        $this->data['keywords']         = $request->search;

        return $this->data;
    }

    public function newSeach(Request $request)
    {
        if (!$request->search) {
            return redirect()->route('frontend.home');
        }
        $products       = Product::with('category')->search($request->query())->get();
        $productCount   = $products->count();

        $providers   = UserServiceProvider::with('category')->search($request->search)->get();
        $posts       = Post::with('category')->where('type', 'news')->search($request->search)->get();

        $this->data['posts']            = $posts;
        $this->data['providers']        = $providers;
        $this->data['products']         = $products->take(5);
        $this->data['productCount']     = $productCount;
        $this->data['is_search']        = $request->search;

        return $this->renderView('frontend.pages.products.new_search');
    }

    public function compare()
    {
        $this->data['brands'] = Category::where('type', 'product')->whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->get();

        return $this->renderView('frontend.purchase.compare_product');
    }

    public function purchase_oil(Request $request)
    {
        $products  = Product::with('review', 'cover')->where('is_active', 1)->where('category_id', 44)->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();

        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;

        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);

            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;

                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }

            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }

        $allFeatures    = DB::table('products')->pluck('tags');

        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
		
		$origins_v = DB::select("SELECT *  FROM `origins` ORDER BY name ASC");

		foreach($origins_v as $raws){
			$tags_v = DB::select("SELECT DISTINCT(tags) FROM `products` WHERE `is_active` = '1' AND origin_id='$raws->id' AND tags !=''");
				 
			 $data_trv[] = array(
				'og_id'   => $raws->id,
				'og_name' => $raws->name,
				'dtv'     => $tags_v 
			 ); 
		}
		
		
		$this->data['org_in'] = $data_trv;
		
		
		/* foreach($data_trv as $rt => $org_ins){
		     echo $org_ins['og_name'];
			 echo "<br />";
			 foreach($org_ins['dtv'] as $dt){
				 echo $dt->tags;
				 echo "<br />"; 
			 } 
			 
			 echo "<hr />"; 
		}  */
		
		  /* print_r("<pre>");
		print_r($data_trv); 
		die(); */
		
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);

        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
		
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];

        //accordion menu link
	$this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->orderBy('sorting', 'ASC')->get();

        return $this->renderView('frontend.product.product_list');
    }
	
    public function purchase_aromatherapy(Request $request)
    {
        $products  = Product::with('review', 'cover')->where('is_active', 1)->where('category_id', 46)->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();

        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;

        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);

            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;

                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }

            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }

        $allFeatures    = DB::table('products')->pluck('tags');

        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
		
		$origins_v = DB::select("SELECT *  FROM `origins` ORDER BY name ASC");

		foreach($origins_v as $raws){
			$tags_v = DB::select("SELECT DISTINCT(tags) FROM `products` WHERE `is_active` = '1' AND origin_id='$raws->id' AND tags !=''");
				 
			 $data_trv[] = array(
				'og_id'   => $raws->id,
				'og_name' => $raws->name,
				'dtv'     => $tags_v 
			 ); 
		}
		
		
		$this->data['org_in'] = $data_trv;
		
		
		/* foreach($data_trv as $rt => $org_ins){
		     echo $org_ins['og_name'];
			 echo "<br />";
			 foreach($org_ins['dtv'] as $dt){
				 echo $dt->tags;
				 echo "<br />"; 
			 } 
			 
			 echo "<hr />"; 
		}  */
		
		  /* print_r("<pre>");
		print_r($data_trv); 
		die(); */
		
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);

        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
		
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];
        //accordion menu link
	$this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->orderBy('sorting', 'ASC')->get();

        return $this->renderView('frontend.product.product_list');
    }
	
	public function purchase_beauty_and_wellness(Request $request)
    {
        $products  = Product::with('review', 'cover')->where('is_active', 1)->where('category_id', 45)->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();

        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;

        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);

            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;

                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }

            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }

        $allFeatures    = DB::table('products')->pluck('tags');

        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
		
		$origins_v = DB::select("SELECT *  FROM `origins` ORDER BY name ASC");

		foreach($origins_v as $raws){
			$tags_v = DB::select("SELECT DISTINCT(tags) FROM `products` WHERE `is_active` = '1' AND origin_id='$raws->id' AND tags !=''");
				 
			 $data_trv[] = array(
				'og_id'   => $raws->id,
				'og_name' => $raws->name,
				'dtv'     => $tags_v 
			 ); 
		}
		
		
		$this->data['org_in'] = $data_trv;
		
		
		/* foreach($data_trv as $rt => $org_ins){
		     echo $org_ins['og_name'];
			 echo "<br />";
			 foreach($org_ins['dtv'] as $dt){
				 echo $dt->tags;
				 echo "<br />"; 
			 } 
			 
			 echo "<hr />"; 
		}  */
		
		  /* print_r("<pre>");
		print_r($data_trv); 
		die(); */
		
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);

        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
		
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];

        //accordion menu link
	$this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->orderBy('sorting', 'ASC')->get();

        return $this->renderView('frontend.product.product_list');
    }

    public function purchase_detail(Request $request)
    {
        $products  = Product::with('review', 'cover')->where('is_active', 1)->where('category_id', $request->id)->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();

        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;

        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);

            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;

                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }

            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }

        $allFeatures    = DB::table('products')->pluck('tags');

        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
		
		$origins_v = DB::select("SELECT *  FROM `origins` ORDER BY name ASC");

		foreach($origins_v as $raws){
			$tags_v = DB::select("SELECT DISTINCT(tags) FROM `products` WHERE `is_active` = '1' AND origin_id='$raws->id' AND tags !=''");
				 
			 $data_trv[] = array(
				'og_id'   => $raws->id,
				'og_name' => $raws->name,
				'dtv'     => $tags_v 
			 ); 
		}
		
		
		$this->data['org_in'] = $data_trv;
		
		
		/* foreach($data_trv as $rt => $org_ins){
		     echo $org_ins['og_name'];
			 echo "<br />";
			 foreach($org_ins['dtv'] as $dt){
				 echo $dt->tags;
				 echo "<br />"; 
			 } 
			 
			 echo "<hr />"; 
		}  */
		
		  /* print_r("<pre>");
		print_r($data_trv); 
		die(); */
		
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);

        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
		
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];
		
	//accordion menu link
	$this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->orderBy('sorting', 'ASC')->get();

        return $this->renderView('frontend.product.product_list');
    }

    public function gift(Request $request){
        $products  = Product::with('review', 'cover')->where('is_active', 1)->whereIn('category_id', ['717','718','719','720'])->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
    
        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;
    
        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);
    
            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
    
                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }
    
            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }
    
        $allFeatures    = DB::table('products')->pluck('tags');
    
        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
        
        
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);
    
        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
        
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];
        
        //accordion menu link
        $this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->get();
        
        return $this->renderView('frontend.product.product_list_gift');
    }

    public function athome(Request $request){
        $products  = Product::with('review', 'cover')->where('is_active', 1)->whereIn('category_id', ['722','723','724'])->filterProduct();
        $brands    = ProductBrand::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
        $origins   = Origin::whereHas('products', function ($query) {
            $query->where('is_active', 1);
        })->orderBy('name', 'ASC')->get();
    
        $this->data['origins']  = $origins;
        $this->data['brands']   = $brands;
        $this->data['sorts']    = $this->productsorts;
    
        if ($request->all()) {
            $price                         = explode(',', $request->price);
            $sort                          = $request->sort;
            $brands                        = explode(',', $request->brand);
            $origins                       = explode(',', $request->origin);
    
            switch ($sort) {
                case 1:
                    $products      = $products->orderBy('view', 'desc')->paginate($this->paginateCount);
                    break;
                case 2:
                    $products      = $products->orderBy('origin_id', 'desc')->paginate($this->paginateCount);
                    break;
                case 3:
                    $tempP         = $products->get()->sortBy('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
                case 4:
                    $tempP         = $products->get()->sortByDesc('priceCurrent')->pluck('id')->toArray();
                    $arrP          = implode(',', $tempP);
                    $products      = Product::whereIn('id', $tempP)->orderByRaw("field(id,{$arrP})", $tempP)->orderBy('updated_at', 'DESC')->paginate($this->paginateCount);
                    break;
    
                default:
                    $products = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
                    break;
            }
    
            $this->data['products']        = $products;
            $this->data['filterbrands']    = $brands;
            $this->data['filterorigin']    = $origins;
            $this->data['lowerprice']      = $price[0];
            $this->data['upperprice']      = $price[1];
            $this->data['filtersort']      = $sort;
        } else {
            $this->data['products'] = $products->orderBy('sorting', 'ASC')->paginate($this->paginateCount);
        }
    
        $allFeatures    = DB::table('products')->pluck('tags');
    
        $features       = [];
        foreach ($allFeatures as $feat) {
            if ($feat) {
                $featuresArray = explode(',', str_replace(' ', '', $feat));
                foreach ($featuresArray as $singleFeature) {
                    array_push($features, $singleFeature);
                }
            }
        }
        
        
        $arrFeat = array_unique($features);
        $sortedF = Arr::sort($arrFeat);
    
        if ($request->keyword) {
            $feats                         = explode(',', $request->keyword);
            $this->data['filterfeature']   = $feats;
        }
        $this->data['features']         = $sortedF;
        
        // SEO
        $this->data['head_title']       = $this->data['purchase_title'];
        $this->data['head_meta_title']  = $this->data['purchase_meta_title'];
        $this->data['head_description'] = $this->data['purchase_description'];
        $this->data['head_keyword']     = $this->data['purchase_keywords'];
        
        //accordion menu link
        $this->data['parent_menu_accr'] = DB::table('categories')->where('parent_id', 0)->get();
        
        return $this->renderView('frontend.product.product_list_athome');
    }
}
