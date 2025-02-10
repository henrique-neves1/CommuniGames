package com.example.projetosi_henriqueneves.utils;

import com.example.projetosi_henriqueneves.model.Cart;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import java.util.ArrayList;

public class CartJsonParser {
    public static ArrayList<Cart> parseJsonCart(JSONArray response) {
        ArrayList<Cart> cartList = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject obj = response.getJSONObject(i);
                cartList.add(new Cart(
                        obj.getInt("id"),
                        obj.getInt("game_id"),
                        obj.getInt("profile_id"),
                        obj.getInt("quantity"),
                        obj.getString("created_at"),
                        obj.getString("updated_at")
                ));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return cartList;
    }
}