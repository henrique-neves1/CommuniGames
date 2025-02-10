package com.example.projetosi_henriqueneves.listeners;

import com.example.projetosi_henriqueneves.model.Cart;
import java.util.ArrayList;

public interface CartListener {
    void onCartUpdated(ArrayList<Cart> cartList);
}