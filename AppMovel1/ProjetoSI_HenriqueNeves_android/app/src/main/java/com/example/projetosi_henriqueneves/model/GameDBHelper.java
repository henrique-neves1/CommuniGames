package com.example.projetosi_henriqueneves.model;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class GameDBHelper extends SQLiteOpenHelper {

    // Database name
    private static final String DB_NAME = "communigames";
    // Table name
    private static final String GAMES = "games";
    // Column names
    private static final String ID = "id";
    private static final String NAME = "name";
    private static final String COVER_BASE64 = "cover_base64";
    private static final String DESCRIPTION = "description";
    private static final String DEVELOPER_NAME = "developer_name";
    private static final String PUBLISHER_NAME = "publisher_name";
    private static final String RELEASE_DATE = "release_date";
    private static final String PRICE = "price";

    private final SQLiteDatabase db;

    public GameDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createTableSQL = "CREATE TABLE " + GAMES + " ("
                + ID + " INTEGER PRIMARY KEY, "
                + NAME + " TEXT NOT NULL, "
                + COVER_BASE64 + " TEXT, "
                + DESCRIPTION + " TEXT, "
                + DEVELOPER_NAME + " TEXT NOT NULL, "
                + PUBLISHER_NAME + " TEXT NOT NULL, "
                + RELEASE_DATE + " TEXT NOT NULL, "
                + PRICE + " REAL NOT NULL"
                + ");";
        sqLiteDatabase.execSQL(createTableSQL);
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int oldVersion, int newVersion) {
        String dropTableSQL = "DROP TABLE IF EXISTS " + GAMES;
        sqLiteDatabase.execSQL(dropTableSQL);
        onCreate(sqLiteDatabase);
    }

    // CRUD Methods

    public Game addGame(Game g) {
        ContentValues values = new ContentValues();
        values.put(NAME, g.getName());
        values.put(COVER_BASE64, g.getCoverbase64());
        values.put(DESCRIPTION, g.getDescription());
        values.put(DEVELOPER_NAME, g.getDeveloper_name());
        values.put(PUBLISHER_NAME, g.getPublisher_name());
        values.put(RELEASE_DATE, g.getReleasedate());
        values.put(PRICE, g.getPrice());

        long id=this.db.insert(GAMES,null,values);
        if(id>-1){
            g.setId((int)id);
            return g;
        }
        return null;
    }

    public void removeAllGames() {
        db.delete(GAMES, null, null);
    }

    public ArrayList<Game> getAllGames() {
        ArrayList<Game> games = new ArrayList<>();

        Cursor cursor = db.query(GAMES,
                new String[]{ID, NAME, COVER_BASE64, DESCRIPTION, DEVELOPER_NAME, PUBLISHER_NAME, RELEASE_DATE, PRICE},
                null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Game game = new Game(
                        cursor.getInt(0),
                        cursor.getString(1),
                        cursor.getString(2),
                        cursor.getString(3),
                        cursor.getString(4),
                        cursor.getString(5),
                        cursor.getString(6),
                        cursor.getDouble(7)
                );
                games.add(game);
            } while (cursor.moveToNext());
        }

        if (!cursor.isClosed()) {
            cursor.close();
        }

        return games;
    }
}