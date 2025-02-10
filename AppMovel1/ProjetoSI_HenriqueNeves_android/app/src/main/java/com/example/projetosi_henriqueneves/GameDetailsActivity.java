package com.example.projetosi_henriqueneves;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.util.Base64;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.projetosi_henriqueneves.model.Game;
import com.example.projetosi_henriqueneves.model.SingletonGames;

public class GameDetailsActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_game_details);

        int gameId = getIntent().getIntExtra("GAME_ID", -1);

        if (gameId != -1) {
            // Fetch game details from SingletonGames
            Game game = SingletonGames.getInstance(this).getGame(gameId);

            if (game != null) {
                TextView tvName = findViewById(R.id.tvName);
                ImageView imgCover = findViewById(R.id.imgCover);
                TextView tvDescription = findViewById(R.id.tvDescription);
                TextView tvPrice = findViewById(R.id.tvPrice);
                TextView tvDeveloperName = findViewById(R.id.tvDeveloperName);
                TextView tvPublisherName = findViewById(R.id.tvPublisherName);
                TextView tvReleaseDate = findViewById(R.id.tvReleaseDate);

                tvName.setText(game.getName());
                tvDescription.setText(game.getDescription());
                tvPrice.setText(String.format("Price: €%.2f", game.getPrice()));
                tvDeveloperName.setText("Developer: " + game.getDeveloper_name());
                tvPublisherName.setText("Publisher: " + game.getPublisher_name());
                tvReleaseDate.setText("Release Date: " + game.getReleasedate());

                String coverPath = game.getCoverPath();
                if (coverPath != null && !coverPath.isEmpty()) {
                    Glide.with(this)
                            .load(coverPath)
                            .diskCacheStrategy(DiskCacheStrategy.ALL)
                            .placeholder(R.drawable.communigames_logo_with_text) // Placeholder image
                            .error(R.drawable.ic_error) // Error image if URL is invalid
                            .into(imgCover);
                }
            } else {
                Toast.makeText(this, "Game not found", Toast.LENGTH_SHORT).show();
                finish();
            }
        } else {
            Toast.makeText(this, "Invalid game ID", Toast.LENGTH_SHORT).show();
            finish();
        }

        Button btnAddToCart = findViewById(R.id.btnAddToCart);

        btnAddToCart.setOnClickListener(v -> {
            // Add to cart logic here
        });
    }
}