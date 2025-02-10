package com.example.projetosi_henriqueneves;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.projetosi_henriqueneves.model.SingletonGames;

public class LoginActivity extends AppCompatActivity {

    @Override
    protected void onStart() {
        super.onStart();
        if (SingletonGames.getInstance(this).isLoggedIn()) {
            Intent intent = new Intent(this, MenuMainActivity.class);
            startActivity(intent);
            finish();
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        EditText etUsername = findViewById(R.id.etUsername);
        EditText etPassword = findViewById(R.id.etPassword);
        Button btnLogin = findViewById(R.id.btnLogin);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String username = etUsername.getText().toString().trim();
                String password = etPassword.getText().toString().trim();

                if (username.isEmpty() || password.isEmpty()) {
                    Toast.makeText(LoginActivity.this, "Please fill in all fields", Toast.LENGTH_SHORT).show();
                    return;
                }

                // Call SingletonGames to log in
                SingletonGames.getInstance(LoginActivity.this).loginUser(
                        username,
                        password,
                        LoginActivity.this,
                        new SingletonGames.LoginCallback() {
                            @Override
                            public void onSuccess() {
                                // Navigate to MenuMainActivity if login succeeds
                                Intent intent = new Intent(LoginActivity.this, MenuMainActivity.class);
                                startActivity(intent);
                                finish();
                            }

                            @Override
                            public void onFailure(String errorMessage) {
                                // Show error message if login fails
                                Toast.makeText(LoginActivity.this, errorMessage, Toast.LENGTH_LONG).show();
                            }
                        }
                );
            }
        });
    }
}