package com.example.projetosi_henriqueneves.utils;

import com.example.projetosi_henriqueneves.model.Profile;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class ProfileJsonParser {
    public static ArrayList<Profile> parseJsonProfiles(JSONArray response) {
        ArrayList<Profile> profiles = new ArrayList<>();
        for (int i = 0; i < response.length(); i++) {
            try {
                JSONObject profileJson = response.getJSONObject(i);
                int id = profileJson.getInt("id");
                String name = profileJson.getString("name");
                String pictureName = profileJson.getString("picture_name");
                String bio = profileJson.getString("bio");
                Double balance = profileJson.isNull("balance") ? null : profileJson.getDouble("balance");
                int userId = profileJson.getInt("user_id");
                String pictureBase64 = profileJson.getString("picture_base64");

                Profile profile = new Profile(id, name, pictureName, bio, balance, userId, pictureBase64);
                profiles.add(profile);
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        return profiles;
    }

    public static Profile parseJsonProfile(String response) {
        try {
            JSONObject profileJson = new JSONObject(response);
            int id = profileJson.getInt("id");
            String name = profileJson.getString("name");
            String pictureName = profileJson.getString("picture_name");
            String bio = profileJson.getString("bio");
            Double balance = profileJson.isNull("balance") ? null : profileJson.getDouble("balance");
            int userId = profileJson.getInt("user_id");
            String pictureBase64 = profileJson.getString("picture_base64");

            return new Profile(id, name, pictureName, bio, balance, userId, pictureBase64);
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }
}
