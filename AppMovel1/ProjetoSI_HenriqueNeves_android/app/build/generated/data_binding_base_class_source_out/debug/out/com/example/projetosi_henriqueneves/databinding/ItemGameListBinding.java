// Generated by view binder compiler. Do not edit!
package com.example.projetosi_henriqueneves.databinding;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.viewbinding.ViewBinding;
import androidx.viewbinding.ViewBindings;
import com.example.projetosi_henriqueneves.R;
import java.lang.NullPointerException;
import java.lang.Override;
import java.lang.String;

public final class ItemGameListBinding implements ViewBinding {
  @NonNull
  private final LinearLayout rootView;

  @NonNull
  public final ImageView imgCover;

  @NonNull
  public final TextView tvName;

  @NonNull
  public final TextView tvPrice;

  private ItemGameListBinding(@NonNull LinearLayout rootView, @NonNull ImageView imgCover,
      @NonNull TextView tvName, @NonNull TextView tvPrice) {
    this.rootView = rootView;
    this.imgCover = imgCover;
    this.tvName = tvName;
    this.tvPrice = tvPrice;
  }

  @Override
  @NonNull
  public LinearLayout getRoot() {
    return rootView;
  }

  @NonNull
  public static ItemGameListBinding inflate(@NonNull LayoutInflater inflater) {
    return inflate(inflater, null, false);
  }

  @NonNull
  public static ItemGameListBinding inflate(@NonNull LayoutInflater inflater,
      @Nullable ViewGroup parent, boolean attachToParent) {
    View root = inflater.inflate(R.layout.item_game_list, parent, false);
    if (attachToParent) {
      parent.addView(root);
    }
    return bind(root);
  }

  @NonNull
  public static ItemGameListBinding bind(@NonNull View rootView) {
    // The body of this method is generated in a way you would not otherwise write.
    // This is done to optimize the compiled bytecode for size and performance.
    int id;
    missingId: {
      id = R.id.imgCover;
      ImageView imgCover = ViewBindings.findChildViewById(rootView, id);
      if (imgCover == null) {
        break missingId;
      }

      id = R.id.tvName;
      TextView tvName = ViewBindings.findChildViewById(rootView, id);
      if (tvName == null) {
        break missingId;
      }

      id = R.id.tvPrice;
      TextView tvPrice = ViewBindings.findChildViewById(rootView, id);
      if (tvPrice == null) {
        break missingId;
      }

      return new ItemGameListBinding((LinearLayout) rootView, imgCover, tvName, tvPrice);
    }
    String missingId = rootView.getResources().getResourceName(id);
    throw new NullPointerException("Missing required view with ID: ".concat(missingId));
  }
}
