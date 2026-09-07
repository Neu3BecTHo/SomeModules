<?php

namespace app\modules\breadHouse\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Cart model for managing shopping cart
 */
class Cart extends ActiveRecord
{
    /**
     * Get cart items from session
     * 
     * @return array Cart items with product and quantity
     */
    public static function getCartItems()
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        $items = [];
        
        foreach ($cart['items'] as $productId => $quantity) {
            $product = Product::findOne($productId);
            if ($product && $product->stock > 0) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
            }
        }
        
        return $items;
    }
    
    /**
     * Get cart total
     * 
     * @return float Total cart value
     */
    public static function getTotal()
    {
        $items = self::getCartItems();
        $total = 0;
        
        foreach ($items as $item) {
            $total += $item['subtotal'];
        }
        
        return $total;
    }
    
    /**
     * Get cart item count
     * 
     * @return int Total number of items
     */
    public static function getCount()
    {
        $items = self::getCartItems();
        return count($items);
    }
    
    /**
     * Get total quantity of items
     * 
     * @return int Total quantity
     */
    public static function getQuantity()
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        return array_sum($cart['items']);
    }
    
    /**
     * Add product to cart
     * 
     * @param int $productId Product ID
     * @param int $quantity Quantity
     * @return bool Success
     */
    public static function addProduct($productId, $quantity = 1)
    {
        $product = Product::findOne($productId);
        if (!$product || $product->stock <= 0) {
            return false;
        }
        
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        
        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId] += $quantity;
        } else {
            $cart['items'][$productId] = $quantity;
        }
        
        Yii::$app->session->set('cart', $cart);
        return true;
    }
    
    /**
     * Update product quantity in cart
     * 
     * @param int $productId Product ID
     * @param int $quantity New quantity
     * @return bool Success
     */
    public static function updateQuantity($productId, $quantity)
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        
        if (!isset($cart['items'][$productId])) {
            return false;
        }
        
        if ($quantity <= 0) {
            unset($cart['items'][$productId]);
        } else {
            $product = Product::findOne($productId);
            if ($product && $quantity <= $product->stock) {
                $cart['items'][$productId] = $quantity;
            } else {
                return false;
            }
        }
        
        Yii::$app->session->set('cart', $cart);
        return true;
    }
    
    /**
     * Remove product from cart
     * 
     * @param int $productId Product ID
     * @return bool Success
     */
    public static function removeProduct($productId)
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        
        if (!isset($cart['items'][$productId])) {
            return false;
        }
        
        unset($cart['items'][$productId]);
        Yii::$app->session->set('cart', $cart);
        return true;
    }
    
    /**
     * Clear cart
     * 
     * @return void
     */
    public static function clear()
    {
        Yii::$app->session->set('cart', ['items' => [], 'delivery' => []]);
    }
    
    /**
     * Get cart delivery info
     * 
     * @return array Delivery info
     */
    public static function getDelivery()
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        return $cart['delivery'];
    }
    
    /**
     * Set cart delivery info
     * 
     * @param array $delivery Delivery info
     * @return void
     */
    public static function setDelivery($delivery)
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        $cart['delivery'] = $delivery;
        Yii::$app->session->set('cart', $cart);
    }
}
