@extends('layouts.main')

@section('gate')

<!-- ISI -->

@php

$number = 1;
$subtotal = 0;
$total = 0;
$entry = 0;
$entries = 0;

@endphp

<br><br>

{{--  
|--------------------------------------------------------------------------
| My Income Category
|--------------------------------------------------------------------------
|
| Pada page ini berisi seluruh category pencatatan
| keuangan pada PT. Tolichris
|
--}}


    <div class="tabheader">
    
        {{-- HEADING --}}
        <h1>My {{ $title }} Category</h1>
    
        {{-- SUMMARY --}}
        <h4>Pada page ini berisi seluruh category pencatatan <br> keuangan pada PT. Tolichris</h4>
    </div>
    
    {{-- Button add new --}}
        <div class="tabaddnew">
            <div id="overlaycategory" onclick="offCategory()"></div>
            {{-- Button pop up--}}
            <button onclick="onCategory()">Add new category +</button>
            <div id="addcategorybox" class="addcategorybox">
                <form method="post" action="/income/addcategory">
                    <h1><center>Add {{ $title }} Category </center></h1>
                    <h2><center>Tambah/catat category income / pendapatan 
                    supaya memantau keuangan menjadi lebih mudah</center></h2>
                    {{ csrf_field() }}
                    <label for="">Category Name : <input type="text" name="incat_name" autocomplete="off" required></label><br>
                    <input type="hidden" name="incat_date" value="{{ date("l, d-M-Y"); }}">
                    <input type="hidden" name="token" 
                        value=
                        "                        
                            @php
        
                            $catuid = uniqid('gfg', true);
                            echo $catuid;
                            
                            @endphp
                       ">
                        
                    <button type="submit">Add new Income + </button>
                    <br>
                </form>
            </div>

            <div id="overlayeditcategory" onclick="offEditCategory()"></div>
        </div>

        {{-- Clear --}}
        <div class="clear"></div>
    

            <div class="tabcategory">
                {{-- Search Feature --}}
                <div class="tabsearch">
                    <p>Search: <input type="text" placeholder="search . ."></p>
                </div>

                {{-- Showing entries --}}
                @foreach ( $categories as $category )
                    @php
                        if ( $category->id = 1 )
                        {
                            $entry = 1;
                        }

                        else {
                            
                        }

                        $entries++;
                    @endphp
                @endforeach

                <p>Show {{ $entries }} entries </p> 

                {{-- TABLE --}}
                    <div class="tabtable">    
                        <table width="100%">
                            <tr>
                                {{-- TABLE HEADER --}}
                                <th><center>No</center></th> 
                                <th><center>Category Name / Nama Kategori</center></th>
                                <th><center>Jenis Kas</center></th>
                                <th><center>Date</center></th>
                                <th><center>Total</center></th>
                                <th><center>Action</center></th>
                            </tr>

                            <tr>
                                {{-- LINE CUTTER --}}
                                <td colspan="99"><div class="line"></div></td>
                            </tr>
                    
                                {{-- FOR EACH --}}
                                @foreach ($categories as $category) 
                                    <tr>
                                        {{-- TABLE MAIN SECTION --}}
                                        <td> <center> {{ $number++ }}. </center></td>
                                        <td><center>{{ $category->name }}</center></td>
                                        <td><center>{{ "Kas Kecil" }}</center></td>
                                        <td><center>{{ $category->incat_entry_date }}</center></td>
                                        <td>
                                            <center>

                                                {{-- PERHITUNGAN PER CATEGORY  --}}
                                                    
                                                @foreach ( $incomes as $calculate )

                                                    @if ($category->name === $calculate->income_category->name)
                                                        
                                                        @php
                                                            $subtotal = $subtotal + $calculate->nominal
                                                        @endphp

                                                    @endif

                                                @endforeach


                                                Rp. {{ number_format($subtotal, 0, " ,","."); }},00
                                                {{-- Rp. {{ $subtotal }},00 --}}

                                                @php

                                                $subtotal = 0;

                                                @endphp

                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <button><img src="/img/eye_white.png" alt=""></button> 
                                                <a href="/income/editlanding/{{ $category->incat_entry_token }}"><button><img src="/img/pencil_white.png" alt=""></button></a> 
                                                <a href="/income/deletecategory/{{ $category->incat_entry_token }}"><button><img src="/img/trash_white.png" alt=""></button></a>
                                            </center>
                                        </td>
                                    </tr>

                                    <tr>
                                        {{-- SPACER --}}
                                        <td><div class="space"></div></td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="99"><hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td><center><b>Total : </b></center></td>
                                        <td>
                                            @foreach ( $incomes as $income )
                                            
                                            @php 
                                                $total = $total + $income->nominal
                                            @endphp

                                            @endforeach
                                            <center>

                                                Rp. {{ number_format($total, 0, ",", "."); }},00
                                                {{-- Rp.{{ $total }},00 --}}
                                            </center>
                                            
                                        </td>
                                    </tr>
                        </table>
                        
                        <div class="tabaddnew">
                            <div id="editcategorybox" class="editcategorybox">
                                <form method="post" action="/income/editcategory/">
                                    <h1><center>Edit {{ $title }} Category </center></h1>
                                    <h2><center>Tambah/catat category income / pendapatan 
                                    supaya memantau keuangan menjadi lebih mudah</center></h2>
                                    {{ csrf_field() }}
                                    <label for="">Category Name : <input type="text" name="incat_name" autocomplete="off" value="" required></label><br>
                                    <input type="hidden" name="incat_date" value="{{ date("l, d-M-Y"); }}">
                                    <input type="hidden" name="token" 
                                        value=
                                        "                        
                                            @php
                        
                                            $catuid = uniqid('gfg', true);
                                            echo $catuid;
                                            
                                            @endphp
                                       ">
                                        
                                    <button type="submit">Add new Income + </button>
                                    <br>
                                </form>
                            </div>
                        </div>
                    </div> 
                <br>

                {{-- ENTRIES --}}
                <p>Showing {{ $entry }} to {{ $entry }} of {{ $entries }} entries</p>

                @php
                                
                $number = 1;
                $entry = 0;
                $entries = 0;

                @endphp

                
            </div>

    <br>















    {{--  
    |--------------------------------------------------------------------------
    | My Income Overview
    |--------------------------------------------------------------------------
    |
    | Pada page ini berisi seluruh transaksi catatan pendapatan yang telah masuk pada PT Tolichris
    |
    --}}

    <div class="tabheader">
        {{-- HEADING --}}
        <h1>My {{ $title }} Overview</h1>

        {{-- SUMMARY --}}
        <h4>Pada page ini berisi seluruh transaksi catatan pendapatan yang telah masuk pada PT Tolichris</h4>
    </div>
        <div class="tabaddnew">
            <div id="overlaytable" onclick="offTable()"></div>
                    <div id="addtablebox" class="addtablebox">
                        <h1>Add New Income</h1>
                        <h2>Tambah/catat setiap pemasukan pada hari ini
                            agar pemasukan menjadi lebih banyak</h2>
                        <div class="tableincomebox">
                            <form method="post" action="/income/addnew">
                            {{ csrf_field() }}
                            <table>
                                <tr>
                                    <td><center> <label for="">Income Description</label> </center></td>
                                    <td><center> : </center></td>
                                    {{-- INPUT_DECS --}}
                                    <td><center> <input type="text" name="input_decs" autocomplete="off" required> </center></td>
                                </tr>
                                <tr>
                                    <td><center> <label for="">Income Category</label> </center></td>
                                    <td><center> : </center></td>
                                    <td>
                                        <center>
                                            {{-- INPUT CATS --}}
                                            <select name="input_cats">
                                                @foreach ($dataopt as $opt)
                                                    <option value="{{ $opt->id }}">{{ $opt->name   }}</option> 
                                                @endforeach
                                                {{-- @for ( $k = 1 ; $k <= 2 ; $k++)
                                                <option value="">{{ $k }}</option> 
                                                @endfor --}}
                                            </select>
                                        </center>
                                    </td>
                                </tr>
                                <tr>
                                    <td><center> <label for="">Kas besar / Kas kecil</label> </center></td>
                                    <td><center> : </center></td>
                                    {{-- INPUT TYPE --}}
                                    <td><center> <input type="text" name="input_type" autocomplete="off" required> </center></td>
                                </tr>
                                <tr>
                                    <td><center> <label for="">nominal</label> </center></td>
                                    <td><center> : </center></td>
                                    <td>
                                        <center> 
                                            {{-- INPUT_NOMINAL --}}
                                            <input type="text" name="input_nominal" autocomplete="off" required>                
                                            {{-- INPUT DATE --}}
                                            <input type="hidden" name="input_date" value="{{ date("l, d-M-Y"); }}">
                                            {{-- INPUT TOKEN --}}
                                            <input type="hidden" name="token" value="@php $tabuid = uniqid('gfg', true); echo $tabuid; @endphp">
                                        </center>
                                    </td>
                                </tr>
                                <tr> 
                                    <td colspan="2"> </td>
                                    <td>
                                        <center>
                                            <button onclick="offTable()" type="submit" >Add new Income + </button>
                                        </center>
                                    </td>
                                </tr>
                            </table>
                                
                        </form>
                        </div>
                    </div>
                    <br>
                    <br>
                    <button onclick="onTable()" type="submit" >Add new Income + </button>
                </div>


        <div class="clear"></div>

            <div class="tabcategory">
                {{-- SEARCH FEATURE --}}
                <div class="tabsearch">
                    <p>Search: <input type="text" placeholder="search . ."></p>
                </div>
            
                {{-- SHOWING ENTRIES --}}
                @foreach ( $categories as $category )
                @php
                    if ( $category->id = 1 )
                    {
                        $entry = 1;
                    }

                    else {
                        
                    }

                    $entries++;
                @endphp
            @endforeach

            <p>Show {{ $entries }} entries </p> 

            
                    {{-- TABLE --}}
                    <div class="tabtable">    
                        <table width="100%">
                            <tr>
                                {{-- TABLE HEADER --}}
                                <th><center>No</center></th> 
                                <th><center>Income Detail / Detail Pemasukan</center></th>
                                <th><center>Category / Kategori</center></th>
                                <th><center>Kas besar / Kas kecil</center></th>
                                <th><center>Nominal</center></th>
                                <th><center>Date</center></th>
                                <th><center>Action</center></th>
                            </tr>
                            <tr>
                                {{-- LINE CUTTER --}}
                                <td colspan="99"><div class="line"></div></td>
                            </tr>
                        
                                {{-- EACH FOR --}}
                                @foreach ($incomes as $income) 
                            <tr>
                                {{-- TABLE MAIN SECTION --}}
                                    <td><center> {{ $number++ }}. </center></td>
                                    <td><center>{{ $income->income_description }}</center></td>
                                    <td><center>{{ $income->income_category->name }}</center></td>
                                    <td><center>{{ "Kas Kecil" }}</center></td>
                                    <td><center>Rp. {{ number_format($income->nominal, 0, " ,","."); }},00</center></td>
                                    <td><center>{{ $income->income_entry_date }}</center></td>
                                    <td>
                                        <center>
                                            <button><img src="/img/eye_white.png" alt=""></button> 
                                            <button><img src="/img/pencil_white.png" alt=""></button> 
                                            <a href="/income/deleteincome/{{ $income->income_token }}"><button><img src="/img/trash_white.png" alt=""></button></a>
                                        </center>
                                </td>
                            </tr>
                        
                            <tr>
                                {{-- SPACER --}}
                                <td><div class="space"></div></td>
                            </tr>

                            @endforeach
                        
                        </table>
                    </div> 
        <br>

        {{-- ENTRIES --}}
        <p>Showing 1 to {{ 1 }} of {{ $number - 1 }} entries</p>
    
        {{-- INI YA BAGIAN --}}
        @if ( $editcategoryjs == 1 )
        <script>    
            const categoryPop = document.getElementById('editcategorybox');
            const categoryOverlay = document.getElementById('overlayeditcategory');
        
            categoryPop.style.display = "block";
            categoryPop.display = "none";
            categoryOverlay.style.display = "block"
        </script>
        @endif

    </div>
        
@endsection



