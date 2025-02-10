package com.example.projetosi_henriqueneves.model;

public class Profile {
    private int id;
    private String name;
    private String pictureName;
    private String bio;
    private Double balance;
    private int userId;
    private String pictureBase64;

    public Profile(int id, String name, String pictureName, String bio, Double balance, int userId, String pictureBase64) {
        this.id = id;
        this.name = name;
        this.pictureName = pictureName;
        this.bio = bio;
        this.balance = balance;
        this.userId = userId;
        this.pictureBase64 = pictureBase64;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getPictureName() {
        return pictureName;
    }

    public void setPictureName(String pictureName) {
        this.pictureName = pictureName;
    }

    public String getBio() {
        return bio;
    }

    public void setBio(String bio) {
        this.bio = bio;
    }

    public Double getBalance() {
        return balance;
    }

    public void setBalance(Double balance) {
        this.balance = balance;
    }

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public String getPictureBase64() {
        return pictureBase64;
    }

    public void setPictureBase64(String pictureBase64) {
        this.pictureBase64 = pictureBase64;
    }
}
