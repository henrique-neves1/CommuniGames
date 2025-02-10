package com.example.projetosi_henriqueneves.model;

public class Cart {
    private int id;
    private int gameId;
    private int profileId;
    private int quantity;
    private String createdAt;
    private String updatedAt;

    public Cart(int id, int gameId, int profileId, int quantity, String createdAt, String updatedAt) {
        this.id = id;
        this.gameId = gameId;
        this.profileId = profileId;
        this.quantity = quantity;
        this.createdAt = createdAt;
        this.updatedAt = updatedAt;
    }

    public int getId() { return id; }
    public int getGameId() { return gameId; }
    public int getProfileId() { return profileId; }
    public int getQuantity() { return quantity; }
    public String getCreatedAt() { return createdAt; }
    public String getUpdatedAt() { return updatedAt; }

    public void setQuantity(int quantity) { this.quantity = quantity; }
}
