package com.example.projetosi_henriqueneves.adapters;

import android.util.Log;

import com.example.projetosi_henriqueneves.model.User;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class UserAdapter {
    public static ArrayList<User> parseJsonUsers(JSONArray response) {
        ArrayList<User> users = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject userJson = response.getJSONObject(i);
                Log.d("UserParser", userJson.toString());
                User user = new User(
                        userJson.getInt("id"),
                        userJson.getString("username"),
                        userJson.getString("password_hash"),
                        userJson.optString("email"),
                        userJson.getInt("status")
                );
                users.add(user);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return users;
    }
}
