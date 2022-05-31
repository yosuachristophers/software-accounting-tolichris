<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// MODEL
use App\Models\Account;
use App\Models\Income;
use App\Models\IncomeCategory;

class IncomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INCOME MAIN PAGE
    |--------------------------------------------------------------------------
    */

    public function start()
    {
        $test = DB::table('dumps')->where('id','1')->get();
        $listcount = DB::table('incomes')->count();


        return view('/pages/incomes/incomes', [
            
            // Title 
            "title" => "Income",

            // Main table View
            "incomes" => Income::latest('income_entry_date')->get(),
            "categories" => \App\Models\IncomeCategory::latest('incat_entry_date')->get(),
            
            // For showing data
            "dataopt" => \App\Models\IncomeCategory::latest('id')->get(),
            "accopt" => \App\Models\Account::latest('id')->get(),

            // Count Entries
            "listcount" => $listcount,

            // N+1
            "dummies" => $test->first(),

            // Useless as fuck
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            "inviews" => Income::latest()->get(),

            // History for search
            "historycat" => null, 
            "historylist" =>null, 

            // FOR JS SHOW 
            "editcategoryjs" => 0,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INCOME SEARCH
    |--------------------------------------------------------------------------
    */

    public function searchcat()
    {
        $search = \App\Models\IncomeCategory::latest();

        if(request('searchcat')) {
            $search->where('name', 'like', '%' . request('searchcat') . '%');
        }

        $historycat = request('searchcat');

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "incomes" => Income::latest()->get(),
            // "income" => Income::where('income_entry_date', date("l, d-M-Y"))->get(),
            // "categories" => \App\Models\IncomeCategory::latest()->get(),
            "categories" => $search->get(),
            // "categories" => \App\Models\IncomeCategory::where('incat_entry_date', date("l, d-M-Y"))->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            // "lists" => Income::where('income_entry_date', date("l, d-M-Y"))->get(),
            "inviews" => Income::latest()->get(),
            "historycat" => $historycat,
            "historylist" =>null,

        ]);
    }

    public function searchlist()
    {
        $search = \App\Models\Income::latest();

        if(request('searchlist')) {
            $search->where('income_description', 'like', '%' . request('searchlist') . '%');
        }

        $historylist = request('searchlist');

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => $search->get(),
            // "income" => Income::where('income_entry_date', date("l, d-M-Y"))->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            // "categories" => \App\Models\IncomeCategory::where('incat_entry_date', date("l, d-M-Y"))->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            // "lists" => Income::where('income_entry_date', date("l, d-M-Y"))->get(),
            "inviews" => Income::latest()->get(),
            "historycat" =>null,
            "historylist" => $historylist,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INCOME TO VIEW CATEGORY / LIST
    |--------------------------------------------------------------------------
    */

    public function viewcategory($incat_slug)
    {
        $category = DB::table('income_categories')->where('incat_slug',$incat_slug)->get();

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 2,
            "incats" => $category,
            "lists" => Income::latest(),
            "inviews" => Income::latest()->get(),
            "historycat" => null,
            "historylist" =>null,
            
        ]);
    }

    public function viewlist($income_slug)
    {
        $inviews = DB::table('incomes')
        ->select('income_description', 'income_categories.name' ,'nominal')
        ->join('income_categories', 'income_categories.id', '=', 'income_category_id')
        ->where('incomes.income_slug',$income_slug)
        ->get();


        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 4,
            "incats" => \App\Models\IncomeCategory::latest()->get(),
            "lists" => Income::latest(),
            "inviews" => $inviews,
            "accopt" => \App\Models\Account::latest()->get(),
            "historycat" => null,
            "historylist" =>null,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | INCOME TO CREATE NEW CATEGORY / LIST
    |--------------------------------------------------------------------------
    */

    public function addcategory(Request $request)
    {
        DB::table('income_categories')->insert([
            'name'=>$request->incat_name,
            'incat_entry_date'=>$request->incat_date,
            'incat_slug'=>$request->incat_slug
        ]);
        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "incomes" => Income::latest()->get(),
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            "inviews" => Income::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
                        "historycat" => null,
            "historylist" =>null,


        ]);
    }


    public function addlist(Request $request)
    {
        DB::table('incomes')->insert([
            'income_description'=>$request->input_decs,
            'income_category_id' => $request->input_cats,
            'income_account_id' => $request->input_acc,
            'income_entry_date' => $request-> input_date,
            'income_slug' => $request-> income_slug,
            'nominal' => $request-> input_nominal
        ]);
        
        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "incomes" => Income::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            "inviews" => Income::latest()->get(),
                        "historycat" => null,
            "historylist" =>null,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INCOME UPDATE LANDING PAGE CATEGORY / LIST
    |--------------------------------------------------------------------------
    */
    public function editcatlanding($incat_slug)
    {
        $category = DB::table('income_categories')->where('incat_slug',$incat_slug)->get();

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 1,
            "incats" => $category,
            "inviews" => Income::latest()->get(),
            "lists" => Income::latest(),
                        "historycat" => null,
            "historylist" =>null,
            "update" => null,
        ]);
    }

    public function editstore($income_slug)
    {
        $list = DB::table('incomes')->where('income_slug',$income_slug)->get();

        // $test = DB::table('incomes')
        // ->select('*', 'income_categories.name')
        // ->join('income_categories', 'income_categories.id', '=', 'income_category_id')
        // ->where('incomes.income_slug',$income_slug)
        // ->get();

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 3,
            "incats" => \App\Models\IncomeCategory::latest()->get(),
            "inviews" => Income::latest()->get(),
            "update" => null,
            "historycat" => null,
            "historylist" =>null,
            "lists" => $list,
            "accopt" => \App\Models\Account::latest()->get(),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INCOME TO UPDATE CATEGORY / LIST
    |--------------------------------------------------------------------------
    */

    public function editcategory(Request $request, $incat_slug)
    {
        DB::table('income_categories')->where('incat_slug', $incat_slug)->update([
            'name'=>$request->incat_name
		]);
        
        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "inviews" => Income::latest()->get(),
            "lists" => Income::latest(),
                        "historycat" => null,
            "historylist" =>null,
        ]);
    }

    public function editlist(Request $request, $income_slug)
    {
        DB::table('incomes')->where('income_slug', $income_slug)->update([
            'income_description'=>$request->input_decs,
            'income_category_id' => $request->input_cats,
            'income_entry_date' => $request-> input_date,
            'income_slug' => $request-> income_slug,
            'nominal' => $request-> input_nominal
		]);
        
        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "inviews" => Income::latest()->get(),
            "historycat" => null,
            "historylist" =>null,
            "lists" => Income::latest(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INCOME TO DELETE CATEGORY / LIST
    |--------------------------------------------------------------------------
    */

    public function deletelist($income_slug)
    {
        DB::table('incomes')->where('income_slug',$income_slug)->delete();        

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            "inviews" => Income::latest()->get(),
            "historycat" => null,
            "historylist" =>null,

        ]);
    }

    public function deletecategory($incat_slug)
    {
        DB::table('income_categories')->where('incat_slug',$incat_slug)->delete();
        

        return view('/pages/incomes/incomes', [
            "title" => "Income",
            "sidebars" => "partials.sidebar",
            "incomes" => Income::latest()->get(),
            "categories" => \App\Models\IncomeCategory::latest()->get(),
            "dataopt" => \App\Models\IncomeCategory::latest()->get(),
            "editcategoryjs" => 0,
            "incats"=> Income::latest()->get(),
            "lists" => Income::latest(),
            "inviews" => Income::latest()->get(),
                        "historycat" => null,
            "historylist" =>null,

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EXPENSE TO PRINT
    |--------------------------------------------------------------------------
    */

    public function printstore()
    {      
        $alldata = DB::table('incomes')
        ->select('income_description', 'income_categories.name' ,'nominal','income_entry_date')
        ->join('income_categories', 'income_categories.id', '=', 'income_category_id')
        // ->where('income.income_slug','income_slug')
        ->get();
        
        return view('/pages/incomes/print', [
            "title" => "Income",
            "bck" => "income",
            "number" => 1,
            "total" => 0,
            "incomes" => $alldata
        ]);
    }
}