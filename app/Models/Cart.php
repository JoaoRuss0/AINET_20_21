<?php

namespace App\Models;

class Cart
{
    // Idea from https://www.youtube.com/watch?v=4J939dDUH4M

    public $items = null;
    public $total_price = 0;
    public $total_qty = 0;

    public function __construct($old_cart)
    {
        if($old_cart)
        {
            $this->items = $old_cart->items;
            $this->total_price = $old_cart->total_price;
            $this->total_qty = $old_cart->total_qty;
        }
    }

    public function add($id, $item)
    {
        // Check if there are already items in the cart and if this item is already there
        if($this->items && array_key_exists($id, $this->items))
        {
            $this->increase($id, $item['quantity']);
            return;
        }

        $this->total_qty += $item['quantity'];
        $precos = Preco::first();
        $stamp = Estampa::find($item['stamp_id']);

        // Item is not in the cart or cart is empty
        $this->items[$id] = [
            'qty' => $item['quantity'],
            'size' => $item['size'],
            'colour_code' => $item['colour_code'],
            'colour_name' => Cor::find($item['colour_code'])->nome,
            'stamp_name' => $stamp->nome,
            'stamp_photo' => $stamp->imagem_url,
            'stamp_id' => $item['stamp_id'],
            'subtotal' => ($item['quantity'] >= $precos->quantidade_desconto) ? $item['quantity'] * $precos->preco_un_catalogo_desconto : $item['quantity'] * $precos->preco_un_catalogo,
        ];

        $this->total_price += $this->items[$id]['subtotal'];
    }

    public function increase($id, $quantity = 1)
    {
        // Just to be sure there are already items in the cart and the item is already there
        if($this->items && array_key_exists($id, $this->items))
        {
            $this->total_qty += $quantity;
            $precos = Preco::first();

            // Item is present, increase its quantity by 1
            $this->items[$id]['qty'] += $quantity ;

            // If item's new quantity is superior/equal to quantity needed for discount
            if($this->items[$id]['qty'] >= $precos->quantidade_desconto)
            {
                // Subtract old subtotal from total price and add new discounted price
                $this->total_price -= $this->items[$id]['subtotal'];
                $this->items[$id]['subtotal'] = $this->items[$id]['qty'] * $precos->preco_un_catalogo_desconto;
                $this->total_price += $this->items[$id]['subtotal'];
            }
            else
            {
                // Simply add item's price if item's quantity is not enough for the discount to be applied
                $this->items[$id]['subtotal'] += $quantity * $precos->preco_un_catalogo;
                $this->total_price += $quantity * $precos->preco_un_catalogo;
            }
        }
    }

    public function decrease($id)
    {
        // Just to be sure there are already items in the cart and the item is already there
        if($this->items && array_key_exists($id, $this->items))
        {

            if($this->items[$id]['qty'] - 1 == 0)
            {
                $this->remove($id);
                return;
            }

            $precos = Preco::first();
            $this->total_qty--;
            $this->items[$id]['qty'] -= 1;

            // If item's new quantity is superior/equal to quantity needed for discount
            if($this->items[$id]['qty'] >= $precos->quantidade_desconto)
            {
                $this->total_price -= $precos->preco_un_catalogo_desconto;
                $this->items[$id]['subtotal'] -= $precos->preco_un_catalogo_desconto;
            }
            else
            {
                $this->total_price -= $this->items[$id]['subtotal'];
                $this->items[$id]['subtotal'] = $this->items[$id]['qty'] * $precos->preco_un_catalogo;
                $this->total_price += $this->items[$id]['subtotal'];
            }
        }
    }

    public function remove($id)
    {
        // Just to be sure there are already items in the cart and the item is already there
        if($this->items && array_key_exists($id, $this->items))
        {
            $this->total_price -= $this->items[$id]['subtotal'];
            $this->total_qty -= $this->items[$id]['qty'];

            unset($this->items[$id]);
        }
    }
}
