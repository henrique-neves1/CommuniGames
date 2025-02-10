package com.example.projetosi_henriqueneves.model;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import androidx.annotation.Nullable;

import java.util.ArrayList;

public class ProfileDBHelper extends SQLiteOpenHelper {
    private static final String DB_NAME = "communigames";
    private static final String PROFILE_TABLE = "profile";

    private static final String ID = "id";
    private static final String NAME = "name";
    private static final String PICTURE_NAME = "picture_name";
    private static final String BIO = "bio";
    private static final String BALANCE = "balance";
    private static final String USER_ID = "user_id";
    private static final String PICTURE_BASE64 = "picture_base64";

    private final SQLiteDatabase db;

    public ProfileDBHelper(@Nullable Context context) {
        super(context, DB_NAME, null, 1);
        this.db = getWritableDatabase();
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        String createTableSQL = "CREATE TABLE " + PROFILE_TABLE + " ("
                + ID + " INTEGER PRIMARY KEY, "
                + NAME + " TEXT NOT NULL, "
                + PICTURE_NAME + " TEXT, "
                + BIO + " TEXT, "
                + BALANCE + " DOUBLE, "
                + USER_ID + " INTEGER NOT NULL, "
                + PICTURE_BASE64 + " TEXT"
                + ");";
        sqLiteDatabase.execSQL(createTableSQL);
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int oldVersion, int newVersion) {
        String dropTableSQL = "DROP TABLE IF EXISTS " + PROFILE_TABLE;
        sqLiteDatabase.execSQL(dropTableSQL);
        onCreate(sqLiteDatabase);
    }

    public Profile addProfile(Profile profile) {
        ContentValues values = new ContentValues();
        values.put(NAME, profile.getName());
        values.put(PICTURE_NAME, profile.getPictureName());
        values.put(BIO, profile.getBio());
        values.put(BALANCE, profile.getBalance());
        values.put(USER_ID, profile.getUserId());
        values.put(PICTURE_BASE64, profile.getPictureBase64());

        long id = this.db.insert(PROFILE_TABLE, null, values);
        if (id > -1) {
            profile.setId((int) id);
            return profile;
        }
        return null;
    }

    public void removeAllProfiles() {
        db.delete(PROFILE_TABLE, null, null);
    }

    public ArrayList<Profile> getAllProfiles() {
        ArrayList<Profile> profiles = new ArrayList<>();
        Cursor cursor = db.query(PROFILE_TABLE,
                new String[]{ID, NAME, PICTURE_NAME, BIO, BALANCE, USER_ID, PICTURE_BASE64},
                null, null, null, null, null);

        if (cursor.moveToFirst()) {
            do {
                Profile profile = new Profile(
                        cursor.getInt(0),
                        cursor.getString(1),
                        cursor.getString(2),
                        cursor.getString(3),
                        cursor.isNull(4) ? null : cursor.getDouble(4),
                        cursor.getInt(5),
                        cursor.getString(6)
                );
                profiles.add(profile);
            } while (cursor.moveToNext());
        }

        if (!cursor.isClosed()) {
            cursor.close();
        }
        return profiles;
    }

}
