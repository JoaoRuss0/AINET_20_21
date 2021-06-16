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
        $cliente_id = $stamp->cliente_id;

        if($cliente_id == null)
        {
            $preco_un = ($item['quantity'] >= $precos->quantidade_desconto) ?  $precos->preco_un_catalogo_desconto : $precos->preco_un_catalogo;
        }
        else
        {
            $preco_un = ($item['quantity'] >= $precos->quantidade_desconto) ?  $precos->preco_un_proprio_desconto : $precos->preco_un_proprio;
        }

        // Item is not in the cart or cart is empty
        $this->items[$id] =
        [
            'estampa_id' => $item['stamp_id'],
            'cor_codigo' => $item['colour_code'],
            'tamanho' => $item['size'],
            'quantidade' => $item['quantity'],
            'preco_un' => $preco_un,
            'subtotal' => $item['quantity'] * $preco_un,
            'colour_name' => Cor::find($item['colour_code'])->nome,
            'stamp_name' => $stamp->nome,
            'stamp_photo' => $stamp->imagem_url,
            'cliente_id' => $cliente_id,
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
            $this->items[$id]['quantidade'] += $quantity ;

            // If item's new quantity is superior/equal to quantity needed for discount
            if($this->items[$id]['quantidade'] >= $precos->quantidade_desconto)
            {
                if($this->items[$id]['cliente_id'] == null)
                {
                    $preco_un = $precos->preco_un_catalogo_desconto;
                }
                else
                {
                    $preco_un = $precos->preco_un_proprio_desconto;
                }

                // Subtract old subtotal from total price and add new discounted price
                $this->total_price -= $this->items[$id]['subtotal'];
                $this->items[$id]['subtotal'] = $this->items[$id]['quantidade'] * $preco_un;
                $this->total_price += $this->items[$id]['subtotal'];
                $this->items[$id]['preco_un'] = $preco_un;
            }
            else
            {
                // Simply add item's price if item's quantity is not enough for the discount to be applied
                $this->items[$id]['subtotal'] += $quantity * $this->items[$id]['preco_un'];
                $this->total_price += $quantity * $this->items[$id]['preco_un'];
            }
        }
    }

    public function decrease($id)
    {
        // Just to be sure there are already items in the cart and the item is already there
        if($this->items && array_key_exists($id, $this->items))
        {

            if($this->items[$id]['quantidade'] - 1 == 0)
            {
                $this->remove($id);
                return;
            }

            $precos = Preco::first();
            $this->total_qty--;
            $this->items[$id]['quantidade'] -= 1;

            // If item's new quantity is still superior/equal to quantity needed for discount
            if($this->items[$id]['quantidade'] >= $precos->quantidade_desconto)
            {
                $this->total_price -= $this->items[$id]['preco_un'];
                $this->items[$id]['subtotal'] -= $this->items[$id]['preco_un'];
            }
            else
            {
                if($this->items[$id]['cliente_id'] == null)
                {
                    $preco_un = $precos->preco_un_catalogo;
                }
                else
                {
                    $preco_un = $precos->preco_un_proprio;
                }

                $this->total_price -= $this->items[$id]['subtotal'];
                $this->items[$id]['subtotal'] = $this->items[$id]['quantidade'] * $preco_un;
                $this->total_price += $this->items[$id]['subtotal'];
                $this->items[$id]['preco_un'] = $preco_un;
            }
        }
    }

    public function remove($id)
    {
        // Just to be sure there are already items in the cart and the item is already there
        if($this->items && array_key_exists($id, $this->items))
        {
            $this->total_price -= $this->items[$id]['subtotal'];
            $this->total_qty -= $this->items[$id]['quantidade'];

            unset($this->items[$id]);
        }
    }
}
