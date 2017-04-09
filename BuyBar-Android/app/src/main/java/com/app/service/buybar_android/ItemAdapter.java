package com.app.service.buybar_android;

import android.app.Activity;
import android.content.Context;
import android.graphics.Color;
import android.graphics.drawable.Drawable;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import java.text.DecimalFormat;
import java.util.ArrayList;

/**
 * Created by daniel on 4/9/17.
 */

public class ItemAdapter extends BaseAdapter {
    ArrayList<Item> itemList;
    private Context context;

    static private Button postButton;
    static private EditText postToPage;

    public ItemAdapter(Context context) {
        this.context = context;
        itemList = new ArrayList<>();
    }

    public Boolean addItem(Item item) {
        boolean add = itemList.add(item);
        return add;
    }

    public Item removeItem(int index) {
        return itemList.remove(index);
    }

    public ArrayList<Item> getItemList() {
        return itemList;
    }

    @Override
    public int getCount() {
        return itemList.size();
    }

    @Override
    public Item getItem(int position) {
        return itemList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(final int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            LayoutInflater mInflater = (LayoutInflater) context.getSystemService(Activity.LAYOUT_INFLATER_SERVICE);
            convertView = mInflater.inflate(R.layout.item_layout, null);
        }

        TextView title = (TextView) convertView.findViewById(R.id.itemTitle);
        TextView price = (TextView) convertView.findViewById(R.id.price);

        title.setText(itemList.get(position).getTitle());

        DecimalFormat df = new DecimalFormat("#.00");
        price.setText("$"+df.format(Double.parseDouble((itemList.get(position).getPrice()+"")+"")/100));

        return convertView;
    }
}
