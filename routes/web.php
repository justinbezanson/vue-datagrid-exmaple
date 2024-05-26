<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Customer;

Route::get('/', function (Request $request) {
    if(!empty($request->get('search'))) {
        $customers = Customer::where('name', 'like', "%{$request->get('search')}%")
            ->orWhere('city', 'like', "%{$request->get('search')}%")
            ->orWhere('email', 'like', "%{$request->get('search')}%")
            ->orWhere('phone', 'like', "%{$request->get('search')}%");
    } else {
        $customers = Customer::select('*');
    }

    $customers = $customers->paginate(10)->through(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'city' => $item->city,
            'email' => $item->email,
            'phone' => $item->phone
        ];
    });

    return Inertia::render('Customer/Index', [
        'customers' => $customers,
        'search' => $request->get('search')   
    ]);
});
