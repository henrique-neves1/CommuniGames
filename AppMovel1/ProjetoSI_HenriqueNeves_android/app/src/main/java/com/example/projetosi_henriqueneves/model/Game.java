package com.example.projetosi_henriqueneves.model;

import java.util.Date;

public class Game {

    private int id;
    private double price;
    private String name, coverbase64, description, developer_name, publisher_name, releasedate;

    public Game(int id, String name, String coverbase64, String description, String developer_name, String publisher_name, String releasedate, double price) {
        this.id = id;
        this.name = name;
        this.coverbase64 = coverbase64;
        this.description = description;
        this.developer_name = developer_name;
        this.publisher_name = publisher_name;
        this.releasedate = releasedate;
        this.price = price;
    }

    public int getId(){
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

    public String getCoverbase64() {
        return coverbase64;
    }

    public void setCoverbase64(String coverbase64) {
        this.coverbase64 = coverbase64;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getDeveloper_name() {
        return developer_name;
    }

    public void setDeveloper_name(String developer_name) {
        this.developer_name = developer_name;
    }

    public String getPublisher_name() {
        return publisher_name;
    }

    public void setPublisher_name(String publisher_name) {
        this.publisher_name = publisher_name;
    }

    public String getReleasedate() {
        return releasedate;
    }

    public void setReleasedate(String releasedate) {
        this.releasedate = releasedate;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    //    private String name;
//    private String coverUrl;
//    private String description;
//    private double price;
//    private String developer;
//    private String publisher;
//    private String releaseDate;
    // Getters and setters
}
