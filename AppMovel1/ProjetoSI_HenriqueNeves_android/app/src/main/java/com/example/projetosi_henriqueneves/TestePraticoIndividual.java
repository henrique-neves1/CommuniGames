package com.example.projetosi_henriqueneves;

import android.content.Context;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;

import com.example.projetosi_henriqueneves.model.SingletonGames;
import com.example.projetosi_henriqueneves.listeners.GamesListener;
import com.example.projetosi_henriqueneves.adapters.GameAdapter;
import com.example.projetosi_henriqueneves.model.Game;

import java.util.ArrayList;

import org.w3c.dom.Text;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link TestePraticoIndividual#newInstance} factory method to
 * create an instance of this fragment.
 */
public class TestePraticoIndividual extends Fragment {

    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    private GameAdapter gameAdapter;

    public TestePraticoIndividual() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment TestePraticoIndividual.
     */
    // TODO: Rename and change types and number of parameters
    public static TestePraticoIndividual newInstance(String param1, String param2) {
        TestePraticoIndividual fragment = new TestePraticoIndividual();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_teste_pratico_individual, container, false);

        Button btnObter = rootView.findViewById(R.id.btnObter);
        TextView textView = rootView.findViewById(R.id.textView);

        Context context = requireContext();
        ArrayList<Game> games = SingletonGames.getInstance(context).getGamesBD();
        int gameLength = games.size();

        btnObter.setOnClickListener(v -> {
            textView.setText("Existem " + gameLength + " produto(s), o mais caro custa " + "" + "€");
        });

        // Inflate the layout for this fragment
        return rootView;
    }
}