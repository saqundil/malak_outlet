<?php

use Illuminate\Support\Facades\Route;
use App\Models\JordanCity;
use Illuminate\Http\Request;

Route::get('/test-city-update/{id}', function($id, Request $request) {
    $city = JordanCity::findOrFail($id);
    
    if ($request->isMethod('post')) {
        // Test update
        try {
            $result = $city->update([
                'name_ar' => $request->input('name_ar', $city->name_ar),
                'name_en' => $request->input('name_en', $city->name_en),
                'delivery_cost' => $request->input('delivery_cost', $city->delivery_cost),
                'delivery_days' => $request->input('delivery_days', $city->delivery_days),
                'is_active' => $request->boolean('is_active', $city->is_active),
            ]);
            
            return response()->json([
                'success' => true,
                'result' => $result,
                'city' => $city->fresh(),
                'message' => 'Update successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Update failed'
            ]);
        }
    }
    
    // Show simple form for testing
    return '
    <h1>Test City Update - ' . $city->display_name . '</h1>
    <form method="POST">
        <input type="hidden" name="_token" value="' . csrf_token() . '">
        <p>Name AR: <input type="text" name="name_ar" value="' . $city->name_ar . '"></p>
        <p>Name EN: <input type="text" name="name_en" value="' . $city->name_en . '"></p>
        <p>Cost: <input type="number" step="0.01" name="delivery_cost" value="' . $city->delivery_cost . '"></p>
        <p>Days: <input type="number" name="delivery_days" value="' . $city->delivery_days . '"></p>
        <p>Active: <input type="checkbox" name="is_active" value="1" ' . ($city->is_active ? 'checked' : '') . '></p>
        <button type="submit">Test Update</button>
    </form>
    ';
})->name('test.city.update');