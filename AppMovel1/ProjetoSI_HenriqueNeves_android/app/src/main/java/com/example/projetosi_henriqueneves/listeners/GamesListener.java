package com.example.projetosi_henriqueneves.listeners;

import com.example.projetosi_henriqueneves.model.Game;

import java.util.ArrayList;

public interface GamesListener {
    void onRefreshGameList(ArrayList<Game> gameList);
}
