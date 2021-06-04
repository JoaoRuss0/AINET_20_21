<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cor;
use App\Models\Cart;
use App\Models\Estampa;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index')
            ->with('title', 'Shopping Cart')
            ->with('cart', session('cart', []));
    }

    public function addView(Estampa $estampa)
    {
        return view('cart.add')
            ->with('title', "Add Item #$estampa->id")
            ->with('cart', session('cart', []))
            ->with('stamp', $estampa)
            ->with('colours', Cor::all())
            ->with('sizes', ['XS', 'S', 'M', 'L', 'XL']);
    }

    public function addToCart(CartStoreRequest $request)
    {
        try
        {
            $old_cart = session('cart') ?? null;
            $new_cart = new Cart($old_cart);

            $validated = $request->validated();
            $colour_code = $validated['colour_code'][0] == '#' ? substr($validated['colour_code'], 1) : $validated['colour_code'];
            $id = $validated['stamp_id'] . "_" . $colour_code . "_" . $validated['size'];

            $new_cart->add($id, $validated);
            session()->put('cart',$new_cart);

            return back()->withInput()
                ->with('message', "Item was successfully added to the shopping cart!")
                ->with('message_type', "message_success");
        }
        catch (Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error adding item to shopping cart.")
                ->with('message_type', "message_error");
        }
    }

    public function update(CartUpdateRequest $request, $id)
    {
        try
        {
            $message = null;

            $old_cart = session('cart') ?? null;
            $new_cart = new Cart($old_cart);

            switch ($request->validated()['action'])
            {
                case 'i':
                    $new_cart->increase($id);
                    $message = "Item's quantity was successfully increased!";
                    break;

                case 'd':
                    $new_cart->decrease($id);
                    $message = "Item's quantity was successfully decreased!";
                    break;

                case 'r':
                    $new_cart->remove($id);
                    $message = "Item was successfully removed!";
                    break;
            }

            session()->put('cart',$new_cart);

            return back()->withInput()
                ->with('message', $message)
                ->with('message_type', "message_success");
        }
        catch (Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error updating shopping cart.")
                ->with('message_type', "message_error");
        }
    }

    public function destroy()
    {
        session()->forget('cart');

        return back()
                ->with('message', "Cart cleared!")
                ->with('message_type', "message_success");
    }
}
