package com.example.projetosi_henriqueneves.model;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import androidx.annotation.Nullable;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;
import com.example.projetosi_henriqueneves.listeners.GameListener;
import com.example.projetosi_henriqueneves.listeners.GamesListener;
import com.example.projetosi_henriqueneves.model.GameDBHelper;
import com.example.projetosi_henriqueneves.utils.GameJsonParser;
import com.example.projetosi_henriqueneves.model.Game;
import com.example.projetosi_henriqueneves.utils.UserJsonParser;

import org.mindrot.jbcrypt.BCrypt;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class SingletonGames {

    private ArrayList<Game> games;
    private static SingletonGames instance = null;
    private GameDBHelper gameDB = null;
    private static RequestQueue volleyQueue = null;
    public static final String mUrlAPIGames = "http://172.22.21.222:8081/api/games";

    private static final String mUrlAPIUsers = "http://172.22.21.222:8081/api/user";
    private static final String mUrlAPIProfiles = "http://172.22.21.222:8081/api/profiles";
    private static final String PREFS_NAME = "UserPrefs";
    private static final String KEY_USER_ID = "user_id";

    private GamesListener gamesListener;
    private GameListener gameListener;

    private int loggedInUserId = -1;
    private JSONObject loggedInUserProfile = null;

    public static synchronized SingletonGames getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGames(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    private SingletonGames(Context context) {
        games = new ArrayList<>();
        gameDB = new GameDBHelper(context);
        loadLoginState(context);
    }

    public GamesListener getGamesListener() {
        return gamesListener;
    }

    public void setGamesListener(GamesListener gamesListener) {
        this.gamesListener = gamesListener;
    }

    public void setGameListener(GameListener gameListener) {
        this.gameListener = gameListener;
    }

    public GameListener getGameListener() {
        return gameListener;
    }

    public ArrayList<Game> getGamesBD() {
        games = gameDB.getAllGames();
        return new ArrayList<>(games);
    }

    public Game getGame(int id) {
        for (Game g : games) {
            if (g.getId() == id) {
                return g;
            }
        }
        return null;
    }

    public void addGame (Game game) {
        Game auxGame=gameDB.addGame(game);
    }

    public void addGamesBD(ArrayList<Game> games) {
        gameDB.removeAllGames();
        for (Game g : games)
            gameDB.addGame(g);
    }

    public void getAllGamesAPI(final Context context) {
        if (!GameJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "No internet connection", Toast.LENGTH_LONG).show();
            games = gameDB.getAllGames();

            if (gamesListener != null) {
                gamesListener.onRefreshGameList(games);
            }
        } else {
            JsonArrayRequest reqGames = new JsonArrayRequest(Request.Method.GET, mUrlAPIGames, null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    Log.d("API Response", response.toString());
                    games = GameJsonParser.parserJsonGames(response);
                    addGamesBD(games);

                    if (gamesListener != null) {
                        gamesListener.onRefreshGameList(games);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_LONG).show();
                }
            });
            volleyQueue.add(reqGames);
        }
    }

    private void saveLoginState(Context context, int userId) {
        SharedPreferences preferences = context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
        preferences.edit().putInt(KEY_USER_ID, userId).apply();
    }

    private void loadLoginState(Context context) {
        SharedPreferences preferences = context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE);
        loggedInUserId = preferences.getInt(KEY_USER_ID, -1);
    }

    public boolean isLoggedIn() {
        return loggedInUserId != -1;
    }

    public void logout(Context context) {
        loggedInUserId = -1;
        loggedInUserProfile = null;
        saveLoginState(context, -1);
    }

    public void loginUser(String username, String password, Context context, final LoginCallback callback) {
        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mUrlAPIUsers, null,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        ArrayList<User> users = UserJsonParser.parserJsonUsers(response);
                        Log.d("LoginDebug", "Users retrieved: " + users.size());

                        for (User user : users) {
                            Log.d("LoginDebug", "Username: " + user.getUsername() + ", Status: " + user.getStatus());
                            Log.d("LoginDebug", "Checking user: " + user.getUsername());
                            if (user.getUsername().equals(username) && user.getStatus() == 10) {
                                Log.d("LoginDebug", "User found: " + user.getUsername());
                                if (verifyPassword(password, user.getPasswordHash())) {
                                    Log.d("LoginDebug", "Password verified for: " + user.getUsername());
                                    loggedInUserId = user.getId();
                                    saveLoginState(context, loggedInUserId);
                                    loadUserProfile(context, callback);
                                    return;
                                } else {
                                    Log.d("LoginDebug", "Password mismatch for: " + user.getUsername());
                                }
                            }
                        }
                        Log.d("LoginFailure", "No match for username or inactive user.");
                        callback.onFailure("Invalid username or password.");
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("LoginDebug", "Network error: " + error.getMessage());
                        callback.onFailure("Network error: " + error.getMessage());
                    }
                }
        );

        volleyQueue.add(request);
    }

    public void loadUserProfile(Context context, final LoginCallback callback) {
        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mUrlAPIProfiles, null,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        try {
                            for (int i = 0; i < response.length(); i++) {
                                JSONObject profile = response.getJSONObject(i);
                                if (profile.getInt("user_id") == loggedInUserId) {
                                    loggedInUserProfile = profile;
                                    callback.onSuccess();
                                    return;
                                }
                            }
                            callback.onFailure("Profile not found.");
                        } catch (JSONException e) {
                            callback.onFailure("Error parsing profile data.");
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        callback.onFailure("Network error: " + error.getMessage());
                    }
                }
        );

        volleyQueue.add(request);
    }

    private boolean verifyPassword(String password, String passwordHash) {
        if (passwordHash.startsWith("$2y")) {
            passwordHash = passwordHash.replaceFirst("\\$2y", "\\$2a");
        }
        try {
            return BCrypt.checkpw(password, passwordHash);
        } catch (Exception e) {
            e.printStackTrace();
            return false;
        }
    }

    public JSONObject getLoggedInUserProfile() {
        return loggedInUserProfile;
    }

    public interface LoginCallback {
        void onSuccess();
        void onFailure(String errorMessage);
    }
}