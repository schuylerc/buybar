package com.app.service.buybar_android;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class CollectInfoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_collect_info);

        EditText email = (EditText) findViewById(R.id.email);
        EditText phoneNumber = (EditText) findViewById(R.id.phoneNumber);

        Button submitInfo = (Button) findViewById(R.id.submitInfo);

        submitInfo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent main = new Intent(CollectInfoActivity.this, MainActivity.class);
                startActivity(main);
                CollectInfoActivity.this.finish();
            }
        });

    }
}
