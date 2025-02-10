package com.example.projetosi_henriqueneves.listeners;

import com.example.projetosi_henriqueneves.model.User;

import java.util.ArrayList;

public interface UsersListener {
    void onRefreshUserList(ArrayList<User> userList);
}
