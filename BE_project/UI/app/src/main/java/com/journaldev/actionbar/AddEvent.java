package com.journaldev.actionbar;

import android.content.Intent;
import android.os.Bundle;
import android.provider.CalendarContract;
import android.provider.CalendarContract.Events;
import android.support.v7.app.ActionBarActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import java.util.Calendar;

public class AddEvent extends ActionBarActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    public void onAddEventClicked(View view){
        Intent intent = new Intent(Intent.ACTION_INSERT);
        intent.setType("vnd.android.cursor.item/event");

        Calendar cal = Calendar.getInstance();
        long startTime = cal.getTimeInMillis();
        long endTime = cal.getTimeInMillis()  + 60 * 60 * 1000;

        intent.putExtra(CalendarContract.EXTRA_EVENT_BEGIN_TIME, startTime);
        intent.putExtra(CalendarContract.EXTRA_EVENT_END_TIME,endTime);
        intent.putExtra(CalendarContract.EXTRA_EVENT_ALL_DAY, true);

        intent.putExtra(Events.TITLE, "Birthday");
        intent.putExtra(Events.DESCRIPTION,  "This is a sample description");
        intent.putExtra(Events.EVENT_LOCATION, "My Guest House");
        intent.putExtra(Events.RRULE, "FREQ=YEARLY");

        startActivity(intent);
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
        startActivity(new Intent(this, AddEvent.class));
    }
}