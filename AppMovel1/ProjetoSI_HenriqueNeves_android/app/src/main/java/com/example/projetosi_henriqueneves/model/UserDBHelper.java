package com.example.projetosi_henriqueneves.model;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class UserDBHelper extends SQLiteOpenHelper {
    private static final String DB_NAME = "communigames";

    private static final String USER = "user";

    private static final String ID = "id";
    private static final String USERNAME = "username";
    private static final String PASSWORD_HASH = "password_hash";
    private static final String EMAIL = "email";
    private static final String STATUS = "status";

    private final SQLiteDatabase db;

    public UserDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createTableSQL = "CREATE TABLE " + USER + " ("
                + ID + " INTEGER PRIMARY KEY, "
                + USERNAME + " TEXT NOT NULL, "
                + PASSWORD_HASH + " TEXT NOT NULL, "
                + EMAIL + " TEXT NOT NULL, "
                + STATUS + " INTEGER"
                + ");";
        sqLiteDatabase.execSQL(createTableSQL);
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int oldVersion, int newVersion) {
        String dropTableSQL = "DROP TABLE IF EXISTS " + USER;
        sqLiteDatabase.execSQL(dropTableSQL);
        onCreate(sqLiteDatabase);
    }

    public User addUser(User u) {
        ContentValues values = new ContentValues();
        values.put(USERNAME, u.getUsername());
        values.put(PASSWORD_HASH, u.getPasswordHash());
        values.put(EMAIL, u.getEmail());
        values.put(STATUS, u.getStatus());

        long id=this.db.insert(USER,null,values);
        if(id>-1){
            u.setId((int)id);
            return u;
        }
        return null;
    }

    public void removeAllUsers() {
        db.delete(USER, null, null);
    }

    public ArrayList<User> getAllUsers() {
        ArrayList<User> users = new ArrayList<>();

        Cursor cursor = db.query(USER,
                new String[]{ID, USERNAME, PASSWORD_HASH, EMAIL, STATUS},
                null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                User user = new User(
                        cursor.getInt(0),
                        cursor.getString(1),
                        cursor.getString(2),
                        cursor.getString(3),
                        cursor.getInt(4)
                );
                users.add(user);
            } while (cursor.moveToNext());
        }

        if (!cursor.isClosed()) {
            cursor.close();
        }

        return users;
    }
}
