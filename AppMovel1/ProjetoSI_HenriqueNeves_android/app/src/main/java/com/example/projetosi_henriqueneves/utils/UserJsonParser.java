package com.example.projetosi_henriqueneves.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.projetosi_henriqueneves.model.Game;
import com.example.projetosi_henriqueneves.model.User;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class UserJsonParser {
    public static ArrayList<User> parserJsonUsers(JSONArray response) {
        ArrayList<User> users = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject user = response.getJSONObject(i);
                int id = user.getInt("id");
                String username = user.getString("username");
                String password_hash = user.getString("password_hash");
                String email = user.getString("email");
                int status = user.getInt("status");

                User auxUser = new User(id, username, password_hash, email, status);
                users.add(auxUser);
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return users;
    }

    public static User parserJsonUser(String response) {
        User auxUser = null;
        try {
            JSONObject user = new JSONObject(response);
            int id = user.getInt("id");
            String username = user.getString("username");
            String password_hash = user.getString("password_hash");
            String email = user.getString("email");
            int status = user.getInt("status");

            auxUser = new User(id, username, password_hash, email, status);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxUser;
    }

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}
