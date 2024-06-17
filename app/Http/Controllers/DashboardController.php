<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Debugbar;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function init() {
        return view('dashboard');
    }

    public function getOrders(Request $request): LengthAwarePaginator
    {
        $search = $request->get('search');
        $on_page = $request->get('items_on_page') != null ? $request->get('items_on_page') : 10;
        if ($search !== null) {
            return Order::with('category')->orWhere('pyramid_number', 'LIKE', '%' . $search . '%')->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            })->orderByDesc('id')->paginate($on_page);
        } else {
            return Order::with('category')->orderByDesc('id')->paginate($on_page);
        }

    }

    public function getCategories(): JsonResponse
    {
        return response()->json(Category::all(), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getOrder(Request $request): JsonResponse
    {
        $id = $request->get('order_id');
        return response()->json(Order::with('category')->find($id), 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function updateOrder(Request $request): string
    {
        $request->validate([
                'pyramid_number' => 'required|integer',
                'category' => 'required|exists:category,id',
                'qty' => 'required|integer',
                'status' => 'required|integer'
            ],
            [
                'pyramid_number.required' => 'Поле "номер пирамиды" обязательно для заполнения',
                'pyramid_number.integer' => 'Поле "номер пирамиды" должно содержать только цифры',
                'category.required' => 'Поле "категория" обязательно для заполнения',
                'category.exists' => 'Категория не найдена',
                'qty.required' => 'Поле "ед/изм" обязательно для заполнения',
                'qty.integer' => 'Поле "ед/изм" должно быть числом',
                'status.required' => 'Поле "статус" обязательно для заполнения',
                'status.integer' => 'Поле "статус" должно быть числом'
            ]
        );
        $id = $request->get('id');
        $pyramid_number = $request->get('pyramid_number');
        $category = $request->get('category');
        $qty = $request->get('qty');
        $status = $request->get('status');

        Order::find($id)->update([
            'pyramid_number' => $pyramid_number,
            'category_id' => $category,
            'qty' => $qty,
            'status' => $status
        ]);
        return 'true';
    }

    public function addOrder(Request $request): string
    {
        $request->validate([
            'pyramid_number' => 'required|integer',
            'category' => 'required|exists:category,id',
            'qty' => 'required|integer',
            'fio' => 'required|string',
            'description' => 'required'
        ],
            [
                'pyramid_number.required' => 'Поле "номер пирамиды" обязательно для заполнения',
                'pyramid_number.integer' => 'Поле "номер пирамиды" должно содержать только цифры',
                'category.required' => 'Поле "категория" обязательно для заполнения',
                'category.exists' => 'Категория не найдена',
                'qty.required' => 'Поле "ед/изм" обязательно для заполнения',
                'qty.integer' => 'Поле "ед/изм" должно быть числом',
                'fio.required' => 'Поле "ФИО" обязательно для заполнения',
                'fio.string' => 'Поле "ФИО" должно быть строкой',
                'description' => 'Поле "описание" обязательно для заполнения'
            ]
        );
        $pyramid_number = $request->get('pyramid_number');
        $category = $request->get('category');
        $qty = $request->get('qty');
        $fio = $request->get('fio');
        $description = $request->get('description');
        $status = 0;

        $order = new Order;
        $order->pyramid_number = $pyramid_number;
        $order->category_id = $category;
        $order->qty = $qty;
        $order->status = $status;
        $order->fio = $fio;
        $order->description = $description;

        $order->save();
        return 'true';
    }
}
