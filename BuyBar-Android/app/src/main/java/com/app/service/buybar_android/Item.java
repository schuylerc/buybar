package com.app.service.buybar_android;

/**
 * Created by daniel on 4/9/17.
 */

public class Item {

    private int id = -1;
    private String title = "";
    private int price = 0;

    public Item(int id, String title, int price){
        this.id = id;
        this.title = title;
        this.price = price;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public int getPrice() {
        return price;
    }

    public void setPrice(int price) {
        this.price = price;
    }
}
