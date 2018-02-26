package com.journaldev.actionbar;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

public class Group extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_group);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    /*@Override
    public boolean onOptionsItemSelected(MenuItem item) { switch(item.getItemId()) {
        case R.id.add:

        case R.id.reset:

        case R.id.about:

        case R.id.exit:


    }
        return(super.onOptionsItemSelected(item));
    }*/

    public void onOptionLogin(MenuItem i)
    {
        startActivity(new Intent(this, Login.class));
    }

    public void onOptionEvent(MenuItem i)
    {
        startActivity(new Intent(this, AddEvent.class));
    }

    public void onOptionGroup(MenuItem i)
    {
        startActivity(new Intent(this, Group.class));
    }
}
