package com.example.projetosi_henriqueneves;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.util.Base64;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import com.example.projetosi_henriqueneves.model.SingletonGames;
import com.google.android.material.navigation.NavigationView;

import org.json.JSONException;
import org.json.JSONObject;

public class MenuMainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener {

    private DrawerLayout drawerLayout;

    SingletonGames singletonGames = SingletonGames.getInstance(this);
    JSONObject userProfile = singletonGames.getLoggedInUserProfile();

    @Override
    protected void onStart() {
        super.onStart();
        if (SingletonGames.getInstance(this).isLoggedIn()) {
            JSONObject profile = SingletonGames.getInstance(this).getLoggedInUserProfile();

            try {
                String name = profile.getString("name");
                String username = profile.getString("username");
                String base64Image = profile.getString("picture_base64");

                TextView tvProfileName = findViewById(R.id.tvProfileName);
                TextView tvUsername = findViewById(R.id.tvUsername);
                ImageView imgProfilePicture = findViewById(R.id.imgProfilePicture);

                tvProfileName.setText(name);
                tvUsername.setText("@" + username);

                byte[] decodedString = Base64.decode(base64Image, Base64.DEFAULT);
                Bitmap decodedByte = BitmapFactory.decodeByteArray(decodedString, 0, decodedString.length);
                imgProfilePicture.setImageBitmap(decodedByte);

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu_main);

        drawerLayout = findViewById(R.id.drawer_layout);

        // Set up the toolbar
        androidx.appcompat.widget.Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        // Set up the drawer toggle
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawerLayout, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawerLayout.addDrawerListener(toggle);
        toggle.syncState();

        // Set up the navigation view
        NavigationView navigationView = findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        // Load the default fragment (e.g., GameListFragment) on startup
        if (savedInstanceState == null) {
            FragmentTransaction fragmentTransaction = getSupportFragmentManager().beginTransaction();
            fragmentTransaction.replace(R.id.fragment_container, new GameListFragment());
            fragmentTransaction.commit();
            navigationView.setCheckedItem(R.id.nav_games);
        }
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull android.view.MenuItem item) {
        // Handle navigation view item clicks
        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();


        if (item.getItemId() == R.id.nav_games) {
            fragmentTransaction.replace(R.id.fragment_container, new GameListFragment());
            fragmentTransaction.commit();
        } else if (item.getItemId() == R.id.nav_teste_pratico){
            fragmentTransaction.replace(R.id.fragment_container, new TestePraticoIndividual());
            fragmentTransaction.commit();
        } else if (item.getItemId() == R.id.menu_logout){
            SingletonGames singletonGames = SingletonGames.getInstance(this);
            singletonGames.logout(this); // Clear login state

            // Redirect to LoginActivity
            Intent intent = new Intent(this, LoginActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK); // Clear activity stack
            startActivity(intent);
            finish();
            return true;
        }

        drawerLayout.closeDrawer(GravityCompat.START);
        return true;
    }

    @Override
    public void onBackPressed() {
        if (drawerLayout.isDrawerOpen(GravityCompat.START)) {
            drawerLayout.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }
}