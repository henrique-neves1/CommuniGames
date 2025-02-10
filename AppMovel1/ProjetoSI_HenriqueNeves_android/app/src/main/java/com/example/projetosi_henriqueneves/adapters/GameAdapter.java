package com.example.projetosi_henriqueneves.adapters;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Base64;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.projetosi_henriqueneves.R;
import com.example.projetosi_henriqueneves.model.Game;

import java.util.ArrayList;

public class GameAdapter extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Game> games;

    public GameAdapter(ArrayList<Game> games, Context context) {
        this.games = games;
        this.context = context;
    }

    @Override
    public int getCount() {
        return games.size();
    }

    @Override
    public Object getItem(int position) {
        return games.get(position);
    }

    @Override
    public long getItemId(int position) {
        return games.get(position).getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_game_list, null);
        }

        ImageView imgGameCover = convertView.findViewById(R.id.imgCover);
        TextView tvGameName = convertView.findViewById(R.id.tvName);
        TextView tvGamePrice = convertView.findViewById(R.id.tvPrice);

        Game game = games.get(position);
        tvGameName.setText(game.getName());
        tvGamePrice.setText(String.format("€%.2f", game.getPrice()));

        String coverPath = game.getCoverPath();
        if (coverPath != null && !coverPath.isEmpty()) {
            Glide.with(context)
                    .load(coverPath)
                    .diskCacheStrategy(DiskCacheStrategy.ALL)
                    .placeholder(R.drawable.communigames_logo_with_text) // Placeholder image in case of loading issues
                    .error(R.drawable.ic_error) // Error image in case URL is invalid
                    .into(imgGameCover);
        }

        return convertView;
    }

    public void updateGames(ArrayList<Game> newGames) {
        this.games = games;
        notifyDataSetChanged();
    }
}