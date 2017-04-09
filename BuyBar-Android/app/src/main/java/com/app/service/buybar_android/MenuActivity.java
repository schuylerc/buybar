package com.app.service.buybar_android;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.Html;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

public class MenuActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);

        TextView logo = (TextView) findViewById(R.id.logo);
        Button checkIn = (Button) findViewById(R.id.checkIn);

        logo.setText(Html.fromHtml("<b>BUY</b>BAR"));

        checkIn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent mainIntent = new Intent(MenuActivity.this, ScannerActivity.class);
                MenuActivity.this.startActivity(mainIntent);
                MenuActivity.this.finish();
            }
        });
    }
}
