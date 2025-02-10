package com.example.projetosi_henriqueneves.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.projetosi_henriqueneves.model.Game;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Date;

public class GameJsonParser {

    public static ArrayList<Game> parserJsonGames(JSONArray response) {
        ArrayList<Game> games = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject game = response.getJSONObject(i);
                int id = game.getInt("id");
                String name = game.getString("name");
                String coverBase64 = game.getString("cover_base64");
                String description = game.getString("description");
                String developerName = game.getString("developer_name");
                String publisherName = game.getString("publisher_name");
                String releaseDate = game.getString("releasedate");
                double price = game.getDouble("price");

                Game auxGame = new Game(id, name, coverBase64, description, developerName, publisherName, releaseDate, price);
                games.add(auxGame);
            } catch (JSONException e) {
                throw new RuntimeException(e);
            }
        }
        return games;
    }

    public static Game parserJsonGame(String response) {
        Game auxGame = null;
        try {
            JSONObject game = new JSONObject(response);
            int id = game.getInt("id");
            String name = game.getString("name");
            String coverBase64 = game.getString("cover_base64");
            String description = game.getString("description");
            String developerName = game.getString("developer_name");
            String publisherName = game.getString("publisher_name");
            String releaseDate = game.getString("releasedate");
            double price = game.getDouble("price");

            auxGame = new Game(id, name, coverBase64, description, developerName, publisherName, releaseDate, price);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return auxGame;
    }

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null && ni.isConnected();
    }
}