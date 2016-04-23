package org.joda.time;

import java.util.HashMap;

class WeeksPool {

    private HashMap<Integer, Weeks> weeks;

    WeeksPool() {
        weeks = new HashMap<Integer, Weeks>();
    }

    Weeks retrieveWeeks(int numeral) {

        Weeks result = getWeeks(numeral);

        if (result == null) {
            result = new Weeks(numeral);
            addWeeks(numeral, result);
        }
        return result;
    }

    private void addWeeks(int numeral, Weeks week) {
        this.weeks.put(numeral, week);
    }

    private Weeks getWeeks(int numeral) {
        return weeks.get(numeral);
    }

}
