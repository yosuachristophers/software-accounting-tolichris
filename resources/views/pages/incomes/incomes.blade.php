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

@include('pages.incomes.category')

<br>

@include('pages.incomes.list')

{{-- SCRIPT --}}
@if ( $editcategoryjs == 1 )
<script>    
    const categoryPop = document.getElementById('editcategorybox');
    const categoryOverlay = document.getElementById('overlayeditcategory');

    categoryPop.style.display = "block";
    categoryPop.display = "none";
    categoryOverlay.style.display = "block"
</script>

@elseif ( $editcategoryjs == 2 )
<script>    
    const categoryPop = document.getElementById('viewcategorybox');
    const categoryOverlay = document.getElementById('overlayviewcategory');

    categoryPop.style.display = "block";
    categoryPop.display = "none";
    categoryOverlay.style.display = "block"
</script>
@endif

        
@endsection



