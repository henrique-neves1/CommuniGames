package com.example.projetosi_henriqueneves;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import com.example.projetosi_henriqueneves.model.SingletonGames;
import com.example.projetosi_henriqueneves.listeners.GamesListener;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.example.projetosi_henriqueneves.adapters.GameAdapter;
import com.example.projetosi_henriqueneves.model.Game;
import com.example.projetosi_henriqueneves.placeholder.PlaceholderContent;

import java.util.ArrayList;

/**
 * A fragment representing a list of Items.
 */
public class GameListFragment extends Fragment {

    // TODO: Customize parameter argument names
    private static final String ARG_COLUMN_COUNT = "column-count";
    // TODO: Customize parameters
    private int mColumnCount = 8;
    private ListView listViewGames;
    private GameAdapter gameAdapter;

    /**
     * Mandatory empty constructor for the fragment manager to instantiate the
     * fragment (e.g. upon screen orientation changes).
     */
    public GameListFragment() {
    }

    // TODO: Customize parameter initialization
    @SuppressWarnings("unused")
    public static GameListFragment newInstance(int columnCount) {
        GameListFragment fragment = new GameListFragment();
        Bundle args = new Bundle();
        args.putInt(ARG_COLUMN_COUNT, columnCount);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        if (getArguments() != null) {
            mColumnCount = getArguments().getInt(ARG_COLUMN_COUNT);
        }
    }

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_game_list, container, false);
        listViewGames = rootView.findViewById(R.id.listViewGames);

        return rootView;
    }

    @Override
    public void onAttach(@NonNull Context context) {
        super.onAttach(context);
        SingletonGames.getInstance(context).setGamesListener(new GamesListener() {
            @Override
            public void onRefreshGameList(ArrayList<Game> games) {
                if (gameAdapter != null) {
                    gameAdapter.updateGames(games);
                }
            }
        });
    }

    @Override
    public void onResume() {
        super.onResume();

        Context context = requireContext();
        ArrayList<Game> games = SingletonGames.getInstance(context).getGamesBD(); // Load from local database
        gameAdapter = new GameAdapter(games, context);
        listViewGames.setAdapter(gameAdapter);

        SingletonGames.getInstance(context).getAllGamesAPI(context); // Fetch fresh data from the API

        // Add item click listener
        listViewGames.setOnItemClickListener((parent, view, position, id) -> {
            Game selectedGame = (Game) gameAdapter.getItem(position);
            Intent intent = new Intent(context, GameDetailsActivity.class);
            intent.putExtra("GAME_ID", selectedGame.getId()); // Pass the game's ID
            startActivity(intent);
        });
    }
}