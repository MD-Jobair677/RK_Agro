<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    function index()
    {
        $pageTitle = 'Supplier List';
        $suppliers = Supplier::searchable(['name', 'phone'])
            ->dateFilter()
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate(getPaginate());
        return view('admin.supplier.index', compact('pageTitle', 'suppliers'));
    }
}
