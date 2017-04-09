package com.app.service.buybar_android;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import java.text.DecimalFormat;

public class MainActivity extends AppCompatActivity {

    static public ItemAdapter adapter;
    static private ListView list;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        list = (ListView) findViewById(R.id.itemList);
        Button closeTab = (Button) findViewById(R.id.closeTab);

        closeTab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                new AlertDialog.Builder(MainActivity.this)
                        .setTitle("Attention")
                        .setMessage("Do you want to close your tab?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override public void onClick(DialogInterface dialog, int which) {
                                // do the acknowledged action, beware, this is run on UI thread
                                Intent menu = new Intent(MainActivity.this, MenuActivity.class);
                                startActivity(menu);
                                MainActivity.this.finish();
                            }
                        })
                        .setNegativeButton(android.R.string.cancel, null) // dismisses by default
                        .create()
                        .show();
            }
        });


        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            DecimalFormat df = new DecimalFormat("#.00");

            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, final int i, long l) {
                Log.d("LOCATION", ""+adapter.getItem(i).getId());
                new AlertDialog.Builder(MainActivity.this)
                        .setTitle("Purchase")
                        .setMessage("Do you want to purchase " + adapter.getItem(i).getTitle() + " for " + ("$"+df.format(Double.parseDouble((MainActivity.adapter.getItem(i).getPrice()+"")+"")/100)) + "?")
                        .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
                            @Override public void onClick(DialogInterface dialog, int which) {
                                // do the acknowledged action, beware, this is run on UI thread
                                CallAPI.makeOrder(MainActivity.this, MainActivity.this, adapter.getItem(i).getId());

                            }
                        })
                        .setNegativeButton(android.R.string.cancel, null) // dismisses by default
                        .create()
                        .show();
            }
        });

        checkItemList();
    }

    private void checkItemList() {
        adapter = new ItemAdapter(this);
        CallAPI.getList(this);
    }

    static public void applyItemList(){
        list.setAdapter(adapter);
    }
}
